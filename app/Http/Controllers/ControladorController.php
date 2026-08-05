<?php

namespace App\Http\Controllers;

use App\Models\Controlador;
use App\Rules\CpfValido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ControladorController extends Controller
{
    /**
     * Exibe a lista de controladores cadastrados e o formulário.
     */
    public function index()
    {
        $controladores = Controlador::orderBy('nome', 'asc')->get();

        return view('controladores.index', compact('controladores'));
    }

    /**
     * Armazena um novo controlador de acesso no banco de dados.
     */
    public function store(Request $request)
    {
        // Limpa o CPF antes de validar (remove pontuação)
        $cpfLimpo = preg_replace('/[^0-9]/', '', (string) $request->input('cpf'));
        $request->merge(['cpf' => $cpfLimpo]);

        // Validação dos dados recebidos do formulário
        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'unique:controladores,cpf', new CpfValido],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'nome.required' => 'O nome do controlador é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Este CPF já está cadastrado no sistema.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ]);

        // Criação do novo controlador
        Controlador::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('controladores.index')
            ->with('success', 'Controlador de acesso cadastrado com sucesso!');
    }

    /**
     * Remove um controlador de acesso do sistema.
     */
    public function destroy($id)
    {
        $controlador = Controlador::findOrFail($id);
        $controlador->delete();

        return redirect()->route('controladores.index')
            ->with('success', 'Controlador removido com sucesso!');
    }
}
