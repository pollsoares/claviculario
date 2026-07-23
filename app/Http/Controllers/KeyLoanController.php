<?php

namespace App\Http\Controllers;

use App\Models\Key;
use App\Models\KeyLoan;
use App\Models\User;
use Illuminate\Http\Request;

class KeyLoanController extends Controller
{
    // Exibe o painel principal
    public function index()
    {
        $availableKeys = Key::where('status', 'available')->orderBy('room_number')->get();
        $users = User::orderBy('name')->get();

        // Empréstimos ativos (ainda não devolvidos)
        $activeLoans = KeyLoan::with(['key', 'user'])
            ->whereNull('returned_at')
            ->orderBy('borrowed_at', 'desc')
            ->get();

        return view('loans.index', compact('availableKeys', 'users', 'activeLoans'));
    }

    // Registra a retirada (Checkout)
    public function checkout(Request $request)
    {
        $request->validate([
            'key_id' => 'required|exists:keys,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $key = Key::findOrFail($request->key_id);

        if ($key->status === 'borrowed') {
            return redirect()->back()->with('error', 'Esta chave já está emprestada.');
        }

        KeyLoan::create([
            'key_id' => $key->id,
            'user_id' => $request->user_id,
            'borrowed_at' => now(),
        ]);

        $key->update(['status' => 'borrowed']);

        return redirect()->back()->with('success', "Chave da Sala {$key->room_number} retirada com sucesso!");
    }

    // Registra a devolução (Checkin)
    public function checkin($id)
    {
        $loan = KeyLoan::findOrFail($id);

        if ($loan->returned_at !== null) {
            return redirect()->back()->with('error', 'Esta chave já foi devolvida anteriormente.');
        }

        // Registra devolução e libera a chave
        $loan->update(['returned_at' => now()]);
        $loan->key->update(['status' => 'available']);

        return redirect()->back()->with('success', "Chave da Sala {$loan->key->room_number} devolvida com sucesso!");
    }
}
