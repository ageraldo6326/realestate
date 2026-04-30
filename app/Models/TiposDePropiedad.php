<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TiposDePropiedad extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['tipo'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $attributes = [
        'tipo' => '',
    ];

    /**
     * Relación: Una TipoDePropiedad tiene muchas Propiedades
     */
    public function propiedades()
    {
        return $this->hasMany(\App\Models\Propiedad::class, 'tipo_propiedad_id', 'id');
    }

    /**
     * Scope: Filtrar por tipo
     */
    public function scopeByTipo($query, $tipo)
    {
        return $query->where('tipo', 'like', "%{$tipo}%");
    }

    /**
     * Scope: Buscar por criterio (tipo o ID)
     */
    public function scopeSearchByCriteria($query, $criterio)
    {
        if (empty($criterio)) {
            return $query;
        }

        return $query->where('tipo', 'like', "%{$criterio}%")
            ->orWhere('id', '=', (int) $criterio);
    }
}
