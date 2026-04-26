<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PropiedadesClickController extends Controller
{
    //

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

        $propiedad = Propiedad::query();

        $propiedad->select('referencia', 'clicks');
        $propiedad->where(function ($query) {
            $query->where('asignada_a', Auth::user()->email)
                ->orWhere('captada_por', Auth::id())
                ->orWhere('captada_por', Auth::user()->email)
                ->orWhere('asignada_a', (string) Auth::id());
        });


        if ($periodo == "Ultimos 30 dias" or $periodo == "") {
            $propiedad->where('created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 30 DAY)'));
        }

        if ($periodo == "Esta semana") {
            $propiedad->where('created_at', '>=', $lunesEstaSemana);
            $propiedad->where('created_at', '<=', $domingoEstaSemana);
        }

        if ($periodo == "La semana pasada") {
            $propiedad->where('created_at', '>=', $lunesSemanaPasada);
            $propiedad->where('created_at', '<=', $domingoSemanaPasada);
        }

        if ($periodo == "Mes pasado") {
            $propiedad->where('created_at', '>=', $primerDiaMesPasado);
            $propiedad->where('created_at', '<=', $ultimoDiaMesPasado);
        }

        if ($periodo == "Este mes") {
            $propiedad->where('created_at', '>=', $primerDiaMesActual);
            $propiedad->where('created_at', '<=', $ultimoDiaMesActual);
        }
        $propiedad->where('clicks', '>', 0);

        $propiedad->orderBy('clicks');
        $propiedad->limit(10);

        $propiedad = $propiedad->pluck('clicks', 'referencia');

        $labels = $propiedad->keys();
        $data = $propiedad->values();

        return view('estadisticas.propiedadesclicks', compact('data', 'labels', 'periodo'));
    }
}
