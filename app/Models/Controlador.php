<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <- IMPORTANTE: Importar essa classe!
use Illuminate\Notifications\Notifiable;

class Controlador extends Authenticatable // <- IMPORTANTE: Estender Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'controladores';

    protected $fillable = [
        'nome',
        'cpf',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
