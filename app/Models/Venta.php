<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_propiedad',
        'refPropiedad',
        'tituloPropiedad',
        'tipoPropiedad',
        'zonaPropiedad',
        'estadoPropiedad',
        'fechaPropiedadCreada',
        'precio',
        'comision',
        'id_vendedor',
        'nombre_vendedor',
        'id_comprador',
        'nombre_comprador',
        'medio_comprador',
        'id_asesor',
        'nombre_asesor',
        'fechaVentaCierre',
        'fechacreadocomprador',
    ];

    protected $casts = [
        'precio'               => 'float',
        'comision'             => 'float',
        'fechaPropiedadCreada' => 'date',
        'fechaVentaCierre'     => 'date',
        'fechacreadocomprador' => 'date',
    ];
}
