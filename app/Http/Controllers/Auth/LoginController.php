<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Controlador; // Usa a model Controlador
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        // 1. Pesquisa no banco usando a Model Controlador
        $controlador = Controlador::where('cpf', $credentials['cpf'])->first();

        if (!$controlador) {
            return redirect()->route('register')
                ->withInput(['cpf' => $credentials['cpf']])
                ->with('info', 'CPF não encontrado. Preencha os dados abaixo para se cadastrar.');
        }

        // 2. Tenta fazer login usando o guard 'controlador'
        $remember = $request->boolean('remember');

        if (Auth::guard('controlador')->attempt(['cpf' => $credentials['cpf'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();

            return redirect()->route('loans.index')->with('success', 'Login realizado com sucesso!');
        }

        throw ValidationException::withMessages([
            'password' => __('Senha incorreta.'),
        ]);
    }

    public function logout(Request $request)
    {
        // Encerra a sessão do guard controlador
        Auth::guard('controlador')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
