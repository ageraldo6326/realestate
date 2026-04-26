<?php

namespace App\Http\Livewire;

use DateTime;
use Livewire\Component;
use App\Models\Clientes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Clientespotencialescerrados extends Component
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

        if ($this->periodo != "PERIODOS") {

            $periodo = $this->periodo;
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

            $clientespotenciales->select(DB::raw('DATE(fechacierre) as Fecha'), DB::raw('COUNT(clientes.id) as total'));
            $clientespotenciales->where('clientes.estatus', '=', 'CIERRE');
            $clientespotenciales->where(function ($query) {
                $query->where('captado_por', Auth::id())
                    ->orWhere('asignado_a', Auth::id());
            });

            if ($periodo == "Ultimos 30 dias" or $periodo == "") {
                $clientespotenciales->where('clientes.fechacierre', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 30 DAY)'));
            }

            if ($periodo == "Esta semana") {
                $clientespotenciales->where('clientes.fechacierre', '>=', $lunesEstaSemana);
                $clientespotenciales->where('clientes.fechacierre', '<=', $domingoEstaSemana);
            }

            if ($periodo == "La semana pasada") {
                $clientespotenciales->where('clientes.fechacierre', '>=', $lunesSemanaPasada);
                $clientespotenciales->where('clientes.fechacierre', '<=', $domingoSemanaPasada);
            }

            if ($periodo == "Mes pasado") {
                $clientespotenciales->where('clientes.fechacierre', '>=', $primerDiaMesPasado);
                $clientespotenciales->where('clientes.fechacierre', '<=', $ultimoDiaMesPasado);
            }

            if ($periodo == "Este mes") {
                $clientespotenciales->where('clientes.fechacierre', '>=', $primerDiaMesActual);
                $clientespotenciales->where('clientes.fechacierre', '<=', $ultimoDiaMesActual);
            }

            $clientespotenciales->groupBy(DB::raw('DATE(fechacierre)'));

            $clientespotenciales = $clientespotenciales->get();

            $mesArray = $clientespotenciales->pluck('Fecha')->toArray();
            $cantidadArray = $clientespotenciales->pluck('total')->toArray();

            $grafica = [
                'labels' => $mesArray,
                'data' => $cantidadArray,
            ];

            for ($i = 0; $i < count($grafica['labels']); $i++) {
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
                        'color' => 'purple',
                        'textColor' => 'black'
                    ];
                }
            }

            if (count($grafica['labels']) > 0) {

                $nuevo_array = collect($nuevo_array);

                $this->labels_mes = $nuevo_array->pluck('labels')->toArray();
                $this->data_mes = $nuevo_array->pluck('data')->toArray();
                $this->colors_mes = $nuevo_array->pluck('color')->toArray();

                $this->emit('actualizarComponenteMes', $this->labels_mes, $this->data_mes, $this->colors_mes, $this->textColors_mes, $this->title_mes);
            } else {

                $this->emit('actualizarComponenteMes');
            }
        }
    }
}
