<?php

namespace App\Http\Controllers;

use App\Models\Key;
use App\Models\KeyLoan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeyLoanController extends Controller
{
    /**
     * Exibe o painel de empréstimos (chaves disponíveis e empréstimos ativos).
     */
    public function index()
    {
        // Busca apenas as chaves que estão disponíveis no momento
        $keys = Key::where('is_available', true)
            ->orderBy('number', 'asc')
            ->get();

        // Busca todos os usuários cadastrados no sistema (tabela 'users')
        $users = User::orderBy('name', 'asc')->get();

        // Busca empréstimos que ainda não foram devolvidos (returned_at nulo)
        $loans = KeyLoan::with(['key', 'user', 'controlador'])
            ->whereNull('returned_at')
            ->latest('borrowed_at')
            ->get();

        return view('loans.index', compact('keys', 'users', 'loans'));
    }

    /**
     * Registra a retirada/empréstimo de uma chave.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'key_id'  => ['required', 'exists:keys,id'],
            'user_id' => ['required', 'exists:users,id'],
        ], [
            'key_id.required'  => 'Selecione uma chave.',
            'key_id.exists'    => 'A chave selecionada não existe no sistema.',
            'user_id.required' => 'Selecione o usuário responsável pela retirada.',
            'user_id.exists'   => 'O usuário selecionado não é válido.',
        ]);

        // Verifica se a chave realmente está disponível para evitar duplicidade de empréstimo
        $key = Key::findOrFail($request->key_id);
        if (!$key->is_available) {
            return back()->withErrors(['key_id' => 'Esta chave já se encontra emprestada.']);
        }

        // Obtém o ID do controlador que está logado na sessão
        $controladorId = Auth::guard('controlador')->id();

        // Registra o empréstimo vinculando Key, User e Controlador
        KeyLoan::create([
            'key_id'         => $request->key_id,
            'user_id'        => $request->user_id,
            'controlador_id' => $controladorId,
            'borrowed_at'    => now(),
        ]);

        // Atualiza o status da chave para indisponível (false)
        $key->update(['is_available' => false]);

        return redirect()->route('loans.index')
            ->with('success', 'Empréstimo de chave registrado com sucesso!');
    }

    /**
     * Registra a devolução de uma chave emprestada.
     */
    public function checkin($id)
    {
        $loan = KeyLoan::findOrFail($id);

        // Se o empréstimo já foi devolvido anteriormente, redireciona
        if ($loan->returned_at !== null) {
            return redirect()->route('loans.index')
                ->with('info', 'Esta chave já foi devolvida anteriormente.');
        }

        // Preenche a data/hora de devolução
        $loan->update([
            'returned_at' => now(),
        ]);

        // Marca a chave como disponível novamente (true)
        if ($loan->key) {
            $loan->key->update(['is_available' => true]);
        }

        return redirect()->route('loans.index')
            ->with('success', 'Chave devolvida e disponível novamente!');
    }

    /**
     * Exibe o histórico geral de empréstimos e devoluções.
     */
    public function history(Request $request)
    {
        $query = KeyLoan::with(['key', 'user', 'controlador'])->latest('borrowed_at');

        // Filtro opcional por nome do usuário que retirou
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $history = $query->paginate(15);

        return view('loans.history', compact('history'));
    }
}
