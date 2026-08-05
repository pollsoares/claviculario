<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CpfValido implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 1. Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', (string) $value);

        // 2. Verifica se possui 11 dígitos
        if (strlen($cpf) != 11) {
            $fail('O campo :attribute deve conter 11 dígitos.');
            return;
        }

        // 3. Rejeita CPFs com todos os dígitos iguais (ex: 111.111.111-11)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            $fail('O campo :attribute informado é inválido.');
            return;
        }

        // 4. Algoritmo de validação do 1º e 2º dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                $fail('O campo :attribute informado é inválido.');
                return;
            }
        }
    }
}

