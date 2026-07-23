<?php

namespace App\Http\Controllers;

use App\Models\Key;
use Illuminate\Http\Request;

class KeyController extends Controller
{
    // Listagem e Formulário de Cadastro
    public function index()
    {
        $keys = Key::orderBy('room_number')->get();
        return view('keys.index', compact('keys'));
    }

    // Salvar Nova Chave
    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:50|unique:keys,room_number',
            'description' => 'nullable|string|max:255',
        ], [
            'room_number.unique' => 'Já existe uma chave cadastrada para esta sala.',
            'room_number.required' => 'O número da sala é obrigatório.',
        ]);

        Key::create([
            'room_number' => $request->room_number,
            'description' => $request->description,
            'status' => 'available',
        ]);

        return redirect()->back()->with('success', 'Chave cadastrada com sucesso!');
    }

    // Deletar Chave (se não estiver emprestada)
    public function destroy(Key $key)
    {
        if ($key->status === 'borrowed') {
            return redirect()->back()->with('error', 'Não é possível excluir uma chave que está emprestada no momento.');
        }

        $key->delete();
        return redirect()->back()->with('success', 'Chave removida com sucesso!');
    }
}
