<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'autor',
        'palabraclave',
        'contenido',
        'foto',
        'metadescription',
        'activo',
        'slug',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
