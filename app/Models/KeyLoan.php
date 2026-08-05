<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyLoan extends Model
{
    use HasFactory;
protected $table = 'key_loans';

    protected $fillable = [
        'key_id',
        'user_id',          // <- ADICIONAR ESTA LINHA
        'controlador_id',
        'borrowed_at',
        'returned_at',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * Relacionamento com a Chave emprestada.
     */
    public function key()
    {
        return $this->belongsTo(Key::class, 'key_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function controlador()
    {
        return $this->belongsTo(Controlador::class, 'controlador_id');
    }
}
