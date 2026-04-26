<?php

namespace App\Http\Controllers\Admin;

use App\Models\Clientes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerClientesPorAsesoresController extends Controller
{
    //

    public function index($asesorid, $fecha_ini, $fecha_fin)
    {

        $clientes = Clientes::where(function ($query) use ($asesorid) {
            $query->where('captado_por', $asesorid)
                ->orWhere('asignado_a', $asesorid);
        })->where('clientes.created_at', '>=', $fecha_ini)
            ->where('clientes.created_at', '<=', $fecha_fin)->get();

        return view('consultas.consultaClientesPorAsesorDetalle', compact('clientes'));
    }
}
