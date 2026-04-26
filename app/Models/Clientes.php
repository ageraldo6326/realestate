<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Clientes extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'titulo',
        'tipo_contacto',
        'tipo_contacto2',
        'telefono',
        'email',
        'comentario',
        'activo',
        'captado_por',
        'asignado_a',
        'medio',
        'testimonio',
        'precio_mini',
        'precio_max',
        'zona_id',
        'tipo',
        'habitaciones',
        'parqueos',
        'estado',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'captado_por');
    }

    public function user2(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'asignado_a');
    }
}
