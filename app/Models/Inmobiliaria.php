<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inmobiliaria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'correo',
        'direccion',
        'telefono',
        'titulo',
        'metadescription',
        'facebook',
        'instagram',
        'tiktok',
        'whatsapp',
        'quienessomos',
        'logo',
        'favicon',
        'slogan',
        'palabrasclaves',
        'aprobacion',
        'dias_propiedad_contactos',
        'dominio',
    ];
}
