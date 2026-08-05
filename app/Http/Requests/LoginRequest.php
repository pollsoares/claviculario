<?php

namespace App\Http\Requests;

use App\Rules\CpfValido;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     */
    public function authorize(): bool
    {
        return true; // Altere para true para permitir a execução
    }

    /**
     * Executado antes da validação. Ideal para limpar e formatar dados de entrada.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('cpf')) {
            // Remove qualquer caractere que não seja número
            $this->merge([
                'cpf' => preg_replace('/[^0-9]/', '', $this->input('cpf')),
            ]);
        }
    }

    /**
     * Regras de validação aplicadas aos dados.
     */
    public function rules(): array
    {
        return [
            'cpf' => ['required', 'string', new CpfValido],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Mensagens de erro personalizadas.
     */
    public function messages(): array
    {
        return [
            'cpf.required' => 'O campo CPF é obrigatório.',
            'password.required' => 'O campo Senha é obrigatório.',
        ];
    }
}
