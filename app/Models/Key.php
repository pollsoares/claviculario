<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table('keys')]
#[Fillable('number','description','is_available')]
class Key extends Model
{
    protected $casts = [
        'is_available' => 'boolean',
    ];
}
