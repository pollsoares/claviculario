<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('key_loans')]
#[Fillable('key_id','user_id','borrowed_at','returned_at')]

class KeyLoan extends Model
{
    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function key(): BelongsTo
    {
        return $this->belongsTo(Key::class);
    }

    /**
     * Relacionamento com o profissional/usuário (Pertence a um Usuário)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
