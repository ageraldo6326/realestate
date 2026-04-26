<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FuenteClientesController extends Controller
{
    function grafico(Request $request)
    {

        $periodo = $request->input('periodo');

        //===================================================================

        // Obtener la fecha actual
        $hoy = new DateTime();

        // Obtener el día de la semana actual (1: lunes, 2: martes, ..., 7: domingo)
        $diaSemanaActual = $hoy->format('N');

        // Obtener el lunes de la semana pasada
        $lunesSemanaPasada = (clone $hoy)->modify('-' . ($diaSemanaActual + 6) . ' days');

        // Obtener el domingo de la semana pasada
        $domingoSemanaPasada = (clone $hoy)->modify('-' . ($diaSemanaActual) . ' days');

        // Imprimir las fechas formateadas date('Y-m-d',strtotime($primerDiaMesPasado)) . ' 00:00:00'
        $lunesSemanaPasada = $lunesSemanaPasada->format('Y-m-d') . ' 00:00:00';
        $domingoSemanaPasada = $domingoSemanaPasada->format('Y-m-d') . ' 23:59:59';

        //===================================================================

        // Obtener el lunes de esta semana
        $lunesEstaSemana = (clone $hoy)->modify('-' . ($diaSemanaActual - 1) . ' days');

        // Obtener el domingo de esta semana
        $domingoEstaSemana = (clone $hoy)->modify('+' . (7 - $diaSemanaActual) . ' days');

        $lunesEstaSemana = $lunesEstaSemana->format('Y-m-d') . ' 00:00:00';
        $domingoEstaSemana = $domingoEstaSemana->format('Y-m-d') . ' 23:59:59';

        //===================================================================


        // Obtener el primer día del mes actual
        $primerDiaMesActual = new DateTime('first day of this month');

        // Obtener el último día del mes actual
        $ultimoDiaMesActual = new DateTime('last day of this month');

        $primerDiaMesActual = $primerDiaMesActual->format('Y-m-d') . ' 00:00:00';
        $ultimoDiaMesActual = $ultimoDiaMesActual->format('Y-m-d') . ' 23:59:59';

        //===================================================================

        // Obtener el primer día del mes pasado
        $primerDiaMesPasado = new DateTime('first day of last month');

        // Obtener el último día del mes pasado
        $ultimoDiaMesPasado = new DateTime('last day of last month');

        $primerDiaMesPasado = $primerDiaMesPasado->format('Y-m-d') . ' 00:00:00';
        $ultimoDiaMesPasado = $ultimoDiaMesPasado->format('Y-m-d') . ' 23:59:59';


        //===================================================================        

        $clientespotenciales = Clientes::query();

        $clientespotenciales->select(DB::raw('medio'), DB::raw('COUNT(clientes.id) as total'));
        $clientespotenciales->where(function ($query) {
            $query->where('captado_por', Auth::id())
                ->orWhere('asignado_a', Auth::id());
        });

        if ($periodo == "Ultimos 30 dias" or $periodo == "") {
            $clientespotenciales->where('clientes.created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 30 DAY)'));
        }

        if ($periodo == "Esta semana") {
            $clientespotenciales->where('clientes.created_at', '>=', $lunesEstaSemana);
            $clientespotenciales->where('clientes.created_at', '<=', $domingoEstaSemana);
        }

        if ($periodo == "La semana pasada") {
            $clientespotenciales->where('clientes.created_at', '>=', $lunesSemanaPasada);
            $clientespotenciales->where('clientes.created_at', '<=', $domingoSemanaPasada);
        }

        if ($periodo == "Mes pasado") {
            $clientespotenciales->where('clientes.created_at', '>=', $primerDiaMesPasado);
            $clientespotenciales->where('clientes.created_at', '<=', $ultimoDiaMesPasado);
        }

        if ($periodo == "Este mes") {
            $clientespotenciales->where('clientes.created_at', '>=', $primerDiaMesActual);
            $clientespotenciales->where('clientes.created_at', '<=', $ultimoDiaMesActual);
        }

        $clientespotenciales->groupBy(DB::raw('medio'));

        // dd($clientespotenciales);

        $clientespotenciales = $clientespotenciales->pluck('total', 'medio');

        $labels = $clientespotenciales->keys();
        $data = $clientespotenciales->values();

        return view('estadisticas.fuenteclientes', compact('data', 'labels', 'periodo'));
    }
}
