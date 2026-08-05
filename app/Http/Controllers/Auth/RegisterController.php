<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Controlador;
use App\Rules\CpfValido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Exibe a tela de cadastro de novos controladores.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Cadastra o novo controlador e realiza o login automático.
     */
    public function register(Request $request)
    {
        // Limpa o CPF (remove pontos e traços) antes da validação
        $cpfLimpo = preg_replace('/[^0-9]/', '', (string) $request->input('cpf'));
        $request->merge(['cpf' => $cpfLimpo]);

        // Validação dos dados
        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'unique:controladores,cpf', new CpfValido],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'nome.required' => 'O nome completo é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Este CPF já está cadastrado no sistema.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'A confirmação de senha não confere.',
        ]);

        // Cria o registro no banco de dados
        $controlador = Controlador::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'password' => Hash::make($request->password),
        ]);

        // Autentica especificamente pelo guard 'controlador'
        Auth::guard('controlador')->login($controlador);

       // Redireciona para o Painel Principal de Empréstimos
        return redirect()->route('loans.index')->with('success', 'Controlador cadastrado com sucesso!');
    }
}
