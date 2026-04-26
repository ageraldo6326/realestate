<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Clientes;
use Nette\Utils\DateTime;
use Illuminate\Support\Facades\DB;

class Clientespotenciales extends Component
{

    public $labels;
    public $data;
    public $periodo = "";

    public $mes_select;
    public $usuario_mes;

    public $labels_mes;
    public $data_mes;
    public $colors_mes;
    public $textColors_mes;
    public $title_mes;

    protected $listeners = ['emitActualizar'];

    public function emitActualizar($value)
    {
        $this->periodo = $value;
        $this->actualizarData();
    }

    public function actualizarData()
    {

        if ($this->periodo!="PERIODOS") {
            $hoy = new DateTime();

            // Obtener el día de la semana actual (1: lunes, 2: martes, ..., 7: domingo)
            $diaSemanaActual = $hoy->format('N');

            // Obtener el lunes de la semana pasada
            $lunesSemanaPasada = (clone $hoy)->modify('-'.($diaSemanaActual + 6).' days');

            // Obtener el domingo de la semana pasada
            $domingoSemanaPasada = (clone $hoy)->modify('-'.($diaSemanaActual).' days');

            // Imprimir las fechas formateadas date('Y-m-d',strtotime($primerDiaMesPasado)) . ' 00:00:00'
            $lunesSemanaPasada = date('Y-m-d',strtotime($lunesSemanaPasada)) . ' 00:00:00';
            $domingoSemanaPasada = date('Y-m-d',strtotime($domingoSemanaPasada)) . ' 23:59:59'; 

            //===================================================================
            
            // Obtener el lunes de esta semana
            $lunesEstaSemana = (clone $hoy)->modify('-'.($diaSemanaActual - 1).' days');

            // Obtener el domingo de esta semana
            $domingoEstaSemana = (clone $hoy)->modify('+'.(7 - $diaSemanaActual).' days');  
            
            $lunesEstaSemana = date('Y-m-d',strtotime($lunesEstaSemana)) . ' 00:00:00';
            $domingoEstaSemana =date('Y-m-d',strtotime($domingoEstaSemana)) . ' 23:59:59'; 

            //===================================================================
        

            // Obtener el primer día del mes actual
            $primerDiaMesActual = new DateTime('first day of this month');

            // Obtener el último día del mes actual
            $ultimoDiaMesActual = new DateTime('last day of this month');

            $primerDiaMesActual = date('Y-m-d',strtotime($primerDiaMesActual)) . ' 00:00:00';
            $ultimoDiaMesActual =date('Y-m-d',strtotime($ultimoDiaMesActual)) . ' 23:59:59';         
            
            //===================================================================

            // Obtener el primer día del mes pasado
            $primerDiaMesPasado = new DateTime('first day of last month');

            // Obtener el último día del mes pasado
            $ultimoDiaMesPasado = new DateTime('last day of last month');   
            
            $primerDiaMesPasado = date('Y-m-d',strtotime($primerDiaMesPasado)) . ' 00:00:00';
            $ultimoDiaMesPasado =date('Y-m-d',strtotime($ultimoDiaMesPasado)) . ' 23:59:59';          


            //===================================================================        
            
            $clientespotenciales = Clientes::query();
            $clientespotenciales->select(DB::raw('DATE(created_at) as Fecha'),DB::raw('COUNT(clientes.id) as total'));

            if ($this->periodo=="Ultimos 30 dias") {
                $clientespotenciales->where('clientes.created_at', '>=',DB::raw( 'DATE_SUB(NOW(), INTERVAL 30 DAY)') );
            }

            if ($this->periodo=="Esta semana") {
                $clientespotenciales->where('clientes.created_at', '>=',$lunesEstaSemana);
                $clientespotenciales->where('clientes.created_at', '<=',$domingoEstaSemana);
            }          

            if ($this->periodo=="La semana pasada") {
                $clientespotenciales->where('clientes.created_at', '>=',$lunesSemanaPasada);
                $clientespotenciales->where('clientes.created_at', '<=',$domingoSemanaPasada);
            }   

            if ($this->periodo=="Mes pasado") {
                $clientespotenciales->where('clientes.created_at', '>=', $primerDiaMesPasado);
                $clientespotenciales->where('clientes.created_at', '<=', $ultimoDiaMesPasado);
            }   
            
            if ($this->periodo=="Este mes") {
                $clientespotenciales->where('clientes.created_at', '>=',$primerDiaMesActual);
                $clientespotenciales->where('clientes.created_at', '<=',$ultimoDiaMesActual);
            }                 
            
            $clientespotenciales->groupBy(DB::raw('DATE(created_at)'));

            $clientespotenciales = $clientespotenciales->get();

            $mesArray = $clientespotenciales->pluck('Fecha')->toArray();
            $cantidadArray = $clientespotenciales->pluck('total')->toArray();

            $grafica = [
                'labels' => $mesArray,
                'data' => $cantidadArray,
            ];

            for ($i = 0; $i < count($grafica['labels']); $i++)
            {
                $labels_temp = 0;
                $data_temp = 0;
                if (in_array($i + 1, $grafica['labels'])) {
                    $indice = array_search($i + 1, $grafica['labels']);
                    $labels_temp = $grafica['labels'][$indice];
                    $data_temp = $grafica['data'][$indice];
                }
                if (count($grafica['labels']) > 0) {
                    $nuevo_array[$i] = [
                        'labels' => $grafica['labels'][$i],
                        'data' => $grafica['data'][$i],
                        'color'=>'purple',
                        'textColor'=>'black'
                    ];
                }
            }

            if (count($grafica['labels']) > 0) {

                $nuevo_array = collect($nuevo_array);

                $this->labels_mes=$nuevo_array->pluck('labels')->toArray();
                $this->data_mes=$nuevo_array->pluck('data')->toArray();
                $this->colors_mes=$nuevo_array->pluck('color')->toArray();

                $this->emit('actualizarComponenteMes', $this->labels_mes, $this->data_mes, $this->colors_mes, $this->textColors_mes, $this->title_mes);
                
            } else {

                $this->emit('actualizarComponenteMes');
            }

            
        } 
    }


    



    public function render()
    {
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
        $lunesSemanaPasada = date('Y-m-d',strtotime($lunesSemanaPasada)) . ' 00:00:00';
        $domingoSemanaPasada = date('Y-m-d',strtotime($domingoSemanaPasada)) . ' 23:59:59'; 

        //===================================================================
        
        // Obtener el lunes de esta semana
        $lunesEstaSemana = (clone $hoy)->modify('-'.($diaSemanaActual - 1).' days');

        // Obtener el domingo de esta semana
        $domingoEstaSemana = (clone $hoy)->modify('+'.(7 - $diaSemanaActual).' days');  
        
        $lunesEstaSemana = date('Y-m-d',strtotime($lunesEstaSemana)) . ' 00:00:00';
        $domingoEstaSemana =date('Y-m-d',strtotime($domingoEstaSemana)) . ' 23:59:59'; 

        //===================================================================
    

        // Obtener el primer día del mes actual
        $primerDiaMesActual = new DateTime('first day of this month');

        // Obtener el último día del mes actual
        $ultimoDiaMesActual = new DateTime('last day of this month');

        $primerDiaMesActual = date('Y-m-d',strtotime($primerDiaMesActual)) . ' 00:00:00';
        $ultimoDiaMesActual =date('Y-m-d',strtotime($ultimoDiaMesActual)) . ' 23:59:59';         
        
        //===================================================================

        // Obtener el primer día del mes pasado
        $primerDiaMesPasado = new DateTime('first day of last month');

        // Obtener el último día del mes pasado
        $ultimoDiaMesPasado = new DateTime('last day of last month');   
        
        $primerDiaMesPasado = date('Y-m-d',strtotime($primerDiaMesPasado)) . ' 00:00:00';
        $ultimoDiaMesPasado =date('Y-m-d',strtotime($ultimoDiaMesPasado)) . ' 23:59:59';          


        //===================================================================        

        $clientespotenciales = Clientes::query();
        
        $clientespotenciales->select(DB::raw('DATE(created_at) as Fecha'),DB::raw('COUNT(clientes.id) as total'));

        if ($this->periodo=="Ultimos 30 dias") {
            $clientespotenciales->where('clientes.created_at', '>=',DB::raw( 'DATE_SUB(NOW(), INTERVAL 30 DAY)') );
        }

        if ($this->periodo=="Esta semana") {
            $clientespotenciales->where('clientes.created_at', '>=',$lunesEstaSemana);
            $clientespotenciales->where('clientes.created_at', '<=',$domingoEstaSemana);
        }          

        if ($this->periodo=="La semana pasada") {
            $clientespotenciales->where('clientes.created_at', '>=',$lunesSemanaPasada);
            $clientespotenciales->where('clientes.created_at', '<=',$domingoSemanaPasada);
        }   

        if ($this->periodo=="Mes pasado") {
            $clientespotenciales->where('clientes.created_at', '>=', $primerDiaMesPasado);
            $clientespotenciales->where('clientes.created_at', '<=', $ultimoDiaMesPasado);
        }   
        
       if ($this->periodo=="Este mes") {
            $clientespotenciales->where('clientes.created_at', '>=',$primerDiaMesActual);
            $clientespotenciales->where('clientes.created_at', '<=',$ultimoDiaMesActual);
        }                 
        
        $clientespotenciales->groupBy(DB::raw('DATE(created_at)'));

        // dd($clientespotenciales);

        $clientespotenciales = $clientespotenciales->pluck('total', 'Fecha');

        $this->labels = $clientespotenciales->keys();
        $this->data = $clientespotenciales->values();     

        return view('livewire.clientespotenciales');
    }
}
