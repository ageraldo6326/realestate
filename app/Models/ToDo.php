<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'fechaLimite',
        'todo_tipo',
        'todo_estatus',
        'user_id',
        'cliente_id',
    ];

    protected $casts = [
        'fechaLimite' => 'datetime',
    ];
}
