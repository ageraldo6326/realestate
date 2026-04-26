<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDoTipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'todo_tipo',
        'color',
    ];
}
