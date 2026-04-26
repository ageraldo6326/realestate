<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portada extends Model
{
    use HasFactory;

    protected $fillable = [
       'minititulo',
       'titulo',
       'descripcion',
       'enlace1',
       'url1',
       'enlace2',
       'url2',
       'video',
       'foto',
       'slug',
       'activo'
    ];



}
