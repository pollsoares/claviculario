<?php

namespace App\Http\Controllers;

use App\Models\Key;
use Illuminate\Http\Request;

class KeyController extends Controller
{
    // Listagem e Formulário de Cadastro
    public function index()
    {
        $keys = Key::orderBy('number', 'asc')->get();

        return view('keys.index', compact('keys'));
    }

    // Salvar Nova Chave
    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|string|max:50|unique:keys,number',
            'description' => 'nullable|string|max:255',
        ], [
            'number.unique' => 'Já existe uma chave cadastrada para esta sala.',
            'number.required' => 'O número da sala é obrigatório.',
        ]);

        Key::create([
            'number' => $request->number,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Chave cadastrada com sucesso!');
    }

    // Deletar Chave (se não estiver emprestada)
    public function destroy(Key $key)
    {
        if ($key->is_available) {
            return redirect()->back()->with('error', 'Não é possível excluir uma chave que está emprestada no momento.');
        }

        $key->delete();
        return redirect()->back()->with('success', 'Chave removida com sucesso!');
    }
}
