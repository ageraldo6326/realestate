<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'contact_at',
        'estatus',
        'probabilidades',
        'captadas_por',
        'precio_mini_dolar',
        'precio_max_dolar',
        'estado_en_dolares',
        'tipo_en_dolares',
        'fechacierre',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'captado_por');
    }

    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asignado_a');
    }

    public function captador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'captado_por');
    }

    public function asesor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asignado_a');
    }
}
