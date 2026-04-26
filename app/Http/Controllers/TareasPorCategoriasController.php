<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\ToDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TareasPorCategoriasController extends Controller
{
    function grafico(Request $request) {
        
        $periodo = $request->input('periodo');

        //===================================================================

        // Obtener la fecha actual
        $hoy = new DateTime();

        // Obtener el día de la semana actual (1: lunes, 2: martes, ..., 7: domingo)
        $diaSemanaActual = $hoy->format('N');

        // Obtener el lunes de la semana pasada
        $lunesSemanaPasada = (clone $hoy)->modify('-'.($diaSemanaActual + 6).' days');

        // Obtener el domingo de la semana pasada
        $domingoSemanaPasada = (clone $hoy)->modify('-'.($diaSemanaActual).' days');

        // Imprimir las fechas formateadas date('Y-m-d',strtotime($primerDiaMesPasado)) . ' 00:00:00'
        $lunesSemanaPasada = $lunesSemanaPasada->format('Y-m-d') . ' 00:00:00';
        $domingoSemanaPasada = $domingoSemanaPasada->format('Y-m-d') . ' 23:59:59'; 

        //===================================================================
        
        // Obtener el lunes de esta semana
        $lunesEstaSemana = (clone $hoy)->modify('-'.($diaSemanaActual - 1).' days');

        // Obtener el domingo de esta semana
        $domingoEstaSemana = (clone $hoy)->modify('+'.(7 - $diaSemanaActual).' days');  
        
        $lunesEstaSemana = $lunesEstaSemana->format('Y-m-d') . ' 00:00:00';
        $domingoEstaSemana =$domingoEstaSemana->format('Y-m-d') . ' 23:59:59'; 

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
        $ultimoDiaMesPasado =$ultimoDiaMesPasado->format('Y-m-d') . ' 23:59:59';          


        //===================================================================        

        $clientespotenciales = ToDo::query();
        
        $clientespotenciales->select(DB::raw('to_do_tipos.todo_tipo'),DB::raw('COUNT(to_dos.id) as total'));
        $clientespotenciales->leftJoin('to_do_tipos','to_dos.todo_tipo','=','to_do_tipos.id');
        $clientespotenciales->where(DB::raw('user_id'),'=',Auth::user()->id);

        if ($periodo=="Ultimos 30 dias" or $periodo=="") {
            $clientespotenciales->where('to_dos.created_at', '>=',DB::raw( 'DATE_SUB(NOW(), INTERVAL 30 DAY)') );
        }

        if ($periodo=="Esta semana") {
            $clientespotenciales->where('to_dos.created_at', '>=',$lunesEstaSemana);
            $clientespotenciales->where('to_dos.created_at', '<=',$domingoEstaSemana);
        }          

        if ($periodo=="La semana pasada") {
            $clientespotenciales->where('to_dos.created_at', '>=',$lunesSemanaPasada);
            $clientespotenciales->where('to_dos.created_at', '<=',$domingoSemanaPasada);
        }   

        if ($periodo=="Mes pasado") {
            $clientespotenciales->where('to_dos.created_at', '>=', $primerDiaMesPasado);
            $clientespotenciales->where('to_dos.created_at', '<=', $ultimoDiaMesPasado);
        }   
        
       if ($periodo=="Este mes") {
            $clientespotenciales->where('to_dos.created_at', '>=',$primerDiaMesActual);
            $clientespotenciales->where('to_dos.created_at', '<=',$ultimoDiaMesActual);
        }                 
        
        $clientespotenciales->groupBy(DB::raw('todo_tipo'));

        // dd($clientespotenciales);

        $clientespotenciales = $clientespotenciales->pluck('total', 'todo_tipo');

        $labels = $clientespotenciales->keys();
        $data = $clientespotenciales->values();     

        return view('estadisticas.tareasporcategorias',compact('data','labels','periodo'));
    }
}
