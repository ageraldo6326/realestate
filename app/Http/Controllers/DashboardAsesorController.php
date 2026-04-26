<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use DateTime;
use App\Models\meses;
use App\Models\Venta;
use App\Models\Inmobiliaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardAsesorController extends Controller
{

    public function index(Request $request)
    {

        $contactOwnershipDays = (int) (optional(Inmobiliaria::query()->first())->dias_propiedad_contactos ?? 90);
        if ($contactOwnershipDays < 1) {
            $contactOwnershipDays = 90;
        }
        $contactOwnershipStart = now()->subDays($contactOwnershipDays)->startOfDay();


        /////////////////////////////////

        $periodo = $request->input('periodo');

        $fi = "";
        $ff = "";

        $fecha_actual = date('Y-m-d');

        $ano_actual = date('Y');
        $fecha_inicial_ano = $ano_actual . '-01-01';
        $fecha_final_ano = $ano_actual . '-12-31';


        $fecha_inicial_mes = date('Y-m-01');
        $ultimo_dia_mes = date('t', strtotime($fecha_actual));
        $fecha_final_mes = date('Y-m-' . $ultimo_dia_mes);


        $mes_pasado = date('Y-m-d', strtotime('-1 month'));
        $fecha_inicial_mes_pasado = date('Y-m-01', strtotime($mes_pasado));
        $ultimo_dia_mes_pasado = date('t', strtotime($mes_pasado));
        $fecha_final_mes_pasado = date('Y-m-' . $ultimo_dia_mes_pasado, strtotime($mes_pasado));

        // Obtener la fecha actual
        $fechaActual = new DateTime();

        // Obtener el año actual y el trimestre actual
        $anioActual = $fechaActual->format('Y');
        $trimestreActual = ceil($fechaActual->format('n') / 3);

        // Calcular el trimestre anterior
        $trimestreAnterior = $trimestreActual - 1;
        if ($trimestreAnterior == 0) {
            $trimestreAnterior = 4;
            $anioAnterior = $anioActual - 1;
        } else {
            $anioAnterior = $anioActual;
        }

        // Calcular la fecha inicial y final del trimestre anterior
        $primerDiaTrimestreAnterior = new DateTime($anioAnterior . '-' . (($trimestreAnterior - 1) * 3 + 1) . '-01');
        $ultimoDiaTrimestreAnterior = new DateTime($anioAnterior . '-' . (($trimestreAnterior - 1) * 3 + 3) . '-31');

        // Calcular el semestre anterior
        $semestreActual = ceil($fechaActual->format('n') / 6);
        $semestreAnterior = $semestreActual - 1;
        if ($semestreAnterior == 0) {
            $semestreAnterior = 2;
            $anioSemestreAnterior = $anioActual - 1;
        } else {
            $anioSemestreAnterior = $anioActual;
        }

        // Calcular la fecha inicial y final del semestre anterior
        $primerDiaSemestreAnterior = new DateTime($anioSemestreAnterior . '-' . (($semestreAnterior - 1) * 6 + 1) . '-01');
        $ultimoDiaSemestreAnterior = new DateTime($anioSemestreAnterior . '-' . (($semestreAnterior - 1) * 6 + 6) . '-30');

        // Calcular el año anterior
        $anioAnterior = $anioActual - 1;

        $anioActual = date('Y');

        // Calcular el año anterior
        $anioAnterior = $anioActual - 1;

        // Fecha inicial del año anterior
        $fechaInicialAnioAnterior = new DateTime($anioAnterior . '-01-01');

        // Fecha final del año anterior
        $fechaFinalAnioAnterior = new DateTime($anioAnterior . '-12-31');


        ////////////////////////////////

        $ventas_por_mes = meses::query();

        $ventas_por_mes->leftjoin(DB::raw('ventas'), DB::raw('meses.numero'), '=', DB::raw('MONTH(ventas.fechaVentaCierre)'));
        $ventas_por_mes->select(
            DB::raw('YEAR(ventas.fechaVentaCierre) AS year'),
            DB::raw('MONTH(ventas.fechaVentaCierre) AS month'),
            DB::raw('meses.mes'),
            DB::raw('COALESCE(COUNT(*),0) AS total_ventas')
        );
        $ventas_por_mes->groupBy(DB::raw('year'), DB::raw('month'), DB::raw('meses.mes'));
        $ventas_por_mes->orderBy(DB::raw('meses.numero'));
        $ventas_por_mes->where('id_asesor', '=', Auth::user()->email);

        $ventas_por_mes_monto = meses::query();

        $ventas_por_mes_monto->leftjoin(DB::raw('ventas'), DB::raw('meses.numero'), '=', DB::raw('MONTH(ventas.fechaVentaCierre)'));
        $ventas_por_mes_monto->select(
            DB::raw('YEAR(ventas.fechaVentaCierre) AS year'),
            DB::raw('MONTH(ventas.fechaVentaCierre) AS month'),
            DB::raw('meses.mes'),
            DB::raw('COALESCE(SUM(precio),0) AS total_ventas')
        );
        $ventas_por_mes_monto->groupBy(DB::raw('year'), DB::raw('month'), DB::raw('meses.mes'));
        $ventas_por_mes_monto->orderBy(DB::raw('meses.numero'));
        $ventas_por_mes_monto->where('id_asesor', '=', Auth::user()->email);

        $ventas = Venta::query();

        $ventas->select(
            DB::raw('COUNT(*) AS CantidadVentas'),
            DB::raw('SUM(precio) AS TotalMontoVentas'),
            DB::raw('AVG(DATEDIFF(fechaVentaCierre, fechaPropiedadCreada)) AS promedioTiempoEnDias'),
            DB::raw('MAX(precio) AS VentaMaxima'),
            DB::raw('AVG(precio) AS VentaPromedio'),
            DB::raw('SUM(precio * (comision/100)) AS TotalComisiones')
        );
        $ventas->where('id_asesor', '=', Auth::user()->email);

        $fuente_de_las_ventas = Venta::query();
        $fuente_de_las_ventas->where('id_asesor', '=', Auth::user()->email);

        $fuente_de_las_ventas->select(
            DB::raw('COUNT(*) AS CantidadVentas'),
            DB::raw('medio_comprador')
        );

        $tipo_de_las_ventas = Venta::query();
        $tipo_de_las_ventas->where('id_asesor', '=', Auth::user()->email);

        $tipo_de_las_ventas->select(
            DB::raw('COUNT(*) AS CantidadVentas'),
            DB::raw('tipoPropiedad')
        );

        $zona_de_las_ventas = Venta::query();
        $zona_de_las_ventas->where('id_asesor', '=', Auth::user()->email);

        $zona_de_las_ventas->select(
            DB::raw('COUNT(*) AS CantidadVentas'),
            DB::raw('zonaPropiedad')
        );

        $estado_de_las_ventas = Venta::query();
        $estado_de_las_ventas->where('id_asesor', '=', Auth::user()->email);

        $estado_de_las_ventas->select(
            DB::raw('COUNT(*) AS CantidadVentas'),
            DB::raw('estadoPropiedad')
        );

        $contactos = Clientes::query();
        $contactos->select(DB::raw('COUNT(*) AS CantidadContactos'));
        $contactos->where(function ($query) {
            $query->where('captado_por', '=', Auth::id())
                ->orWhere('asignado_a', '=', Auth::id());
        });
        $contactos->where('created_at', '>=', $contactOwnershipStart);

        $contactos_altas = Clientes::query();
        $contactos_altas->select(DB::raw('COUNT(*) AS CantidadContactos'));
        $contactos_altas->where('probabilidades', '=', 'ALTAS');
        $contactos_altas->where(function ($query) {
            $query->where('captado_por', '=', Auth::id())
                ->orWhere('asignado_a', '=', Auth::id());
        });
        $contactos_altas->where('created_at', '>=', $contactOwnershipStart);

        if ($periodo == $ano_actual or $periodo == "") {

            $contactos->where('created_at', '>=', $fecha_inicial_ano);
            $contactos->where('created_at', '<=', $fecha_final_ano);

            $contactos_altas->where('created_at', '>=', $fecha_inicial_ano);
            $contactos_altas->where('created_at', '<=', $fecha_final_ano);

            $ventas->where('fechaVentaCierre', '>=', $fecha_inicial_ano);
            $ventas->where('fechaVentaCierre', '<=', $fecha_final_ano);

            $fuente_de_las_ventas->where('fechaVentaCierre', '>=', $fecha_inicial_ano);
            $fuente_de_las_ventas->where('fechaVentaCierre', '<=', $fecha_final_ano);

            $tipo_de_las_ventas->where('fechaVentaCierre', '>=', $fecha_inicial_ano);
            $tipo_de_las_ventas->where('fechaVentaCierre', '<=', $fecha_final_ano);

            $zona_de_las_ventas->where('fechaVentaCierre', '>=', $fecha_inicial_ano);
            $zona_de_las_ventas->where('fechaVentaCierre', '<=', $fecha_final_ano);

            $estado_de_las_ventas->where('fechaVentaCierre', '>=', $fecha_inicial_ano);
            $estado_de_las_ventas->where('fechaVentaCierre', '<=', $fecha_final_ano);

            $ventas_por_mes->where('fechaVentaCierre', '>=', $fecha_inicial_ano);
            $ventas_por_mes->where('fechaVentaCierre', '<=', $fecha_final_ano);

            $ventas_por_mes_monto->where('fechaVentaCierre', '>=', $fecha_inicial_ano);
            $ventas_por_mes_monto->where('fechaVentaCierre', '<=', $fecha_final_ano);

            $fi = $fecha_inicial_ano;
            $ff = $fecha_final_ano;
        }

        if ($periodo == "Ultimo trimestre") {

            $contactos->where('created_at', '>=', $primerDiaTrimestreAnterior);
            $contactos->where('created_at', '<=', $ultimoDiaTrimestreAnterior);

            $contactos_altas->where('created_at', '>=', $primerDiaTrimestreAnterior);
            $contactos_altas->where('created_at', '<=', $ultimoDiaTrimestreAnterior);

            $ventas->where('fechaVentaCierre', '>=', $primerDiaTrimestreAnterior);
            $ventas->where('fechaVentaCierre', '<=', $ultimoDiaTrimestreAnterior);

            $fuente_de_las_ventas->where('fechaVentaCierre', '>=', $primerDiaTrimestreAnterior);
            $fuente_de_las_ventas->where('fechaVentaCierre', '<=', $ultimoDiaTrimestreAnterior);

            $tipo_de_las_ventas->where('fechaVentaCierre', '>=', $primerDiaTrimestreAnterior);
            $tipo_de_las_ventas->where('fechaVentaCierre', '<=', $ultimoDiaTrimestreAnterior);

            $zona_de_las_ventas->where('fechaVentaCierre', '>=', $primerDiaTrimestreAnterior);
            $zona_de_las_ventas->where('fechaVentaCierre', '<=', $ultimoDiaTrimestreAnterior);

            $estado_de_las_ventas->where('fechaVentaCierre', '>=', $primerDiaTrimestreAnterior);
            $estado_de_las_ventas->where('fechaVentaCierre', '<=', $ultimoDiaTrimestreAnterior);

            $ventas_por_mes->where('fechaVentaCierre', '>=', $primerDiaTrimestreAnterior);
            $ventas_por_mes->where('fechaVentaCierre', '<=', $ultimoDiaTrimestreAnterior);

            $ventas_por_mes_monto->where('fechaVentaCierre', '>=', $primerDiaTrimestreAnterior);
            $ventas_por_mes_monto->where('fechaVentaCierre', '<=', $ultimoDiaTrimestreAnterior);

            $fi = $primerDiaTrimestreAnterior->format('Y-m-d H:i:s');
            $ff = $ultimoDiaTrimestreAnterior->format('Y-m-d H:i:s');
        }

        if ($periodo == "Ano pasado") {

            $contactos_altas->where('created_at', '>=', $fechaInicialAnioAnterior);
            $contactos_altas->where('created_at', '<=', $fechaFinalAnioAnterior);

            $contactos->where('created_at', '>=', $fechaInicialAnioAnterior);
            $contactos->where('created_at', '<=', $fechaFinalAnioAnterior);

            $ventas->where('fechaVentaCierre', '>=', $fechaInicialAnioAnterior);
            $ventas->where('fechaVentaCierre', '<=', $fechaFinalAnioAnterior);

            $fuente_de_las_ventas->where('fechaVentaCierre', '>=', $fechaInicialAnioAnterior);
            $fuente_de_las_ventas->where('fechaVentaCierre', '<=', $fechaFinalAnioAnterior);

            $tipo_de_las_ventas->where('fechaVentaCierre', '>=', $fechaInicialAnioAnterior);
            $tipo_de_las_ventas->where('fechaVentaCierre', '<=', $fechaFinalAnioAnterior);

            $zona_de_las_ventas->where('fechaVentaCierre', '>=', $fechaInicialAnioAnterior);
            $zona_de_las_ventas->where('fechaVentaCierre', '<=', $fechaFinalAnioAnterior);

            $estado_de_las_ventas->where('fechaVentaCierre', '>=', $fechaInicialAnioAnterior);
            $estado_de_las_ventas->where('fechaVentaCierre', '<=', $fechaFinalAnioAnterior);

            $ventas_por_mes->where('fechaVentaCierre', '>=', $fechaInicialAnioAnterior);
            $ventas_por_mes->where('fechaVentaCierre', '<=', $fechaFinalAnioAnterior);

            $ventas_por_mes_monto->where('fechaVentaCierre', '>=', $fechaInicialAnioAnterior);
            $ventas_por_mes_monto->where('fechaVentaCierre', '<=', $fechaFinalAnioAnterior);

            $fi = $fechaInicialAnioAnterior->format('Y-m-d H:i:s');
            $ff = $fechaFinalAnioAnterior->format('Y-m-d H:i:s');
        }

        if ($periodo == "Ultimo semestre") {

            $contactos_altas->where('created_at', '>=', $primerDiaSemestreAnterior);
            $contactos_altas->where('created_at', '<=', $ultimoDiaSemestreAnterior);

            $contactos->where('created_at', '>=', $primerDiaSemestreAnterior);
            $contactos->where('created_at', '<=', $ultimoDiaSemestreAnterior);

            $ventas->where('fechaVentaCierre', '>=', $primerDiaSemestreAnterior);
            $ventas->where('fechaVentaCierre', '<=', $ultimoDiaSemestreAnterior);

            $fuente_de_las_ventas->where('fechaVentaCierre', '>=', $primerDiaSemestreAnterior);
            $fuente_de_las_ventas->where('fechaVentaCierre', '<=', $ultimoDiaSemestreAnterior);

            $tipo_de_las_ventas->where('fechaVentaCierre', '>=', $primerDiaSemestreAnterior);
            $tipo_de_las_ventas->where('fechaVentaCierre', '<=', $ultimoDiaSemestreAnterior);

            $zona_de_las_ventas->where('fechaVentaCierre', '>=', $primerDiaSemestreAnterior);
            $zona_de_las_ventas->where('fechaVentaCierre', '<=', $ultimoDiaSemestreAnterior);

            $estado_de_las_ventas->where('fechaVentaCierre', '>=', $primerDiaSemestreAnterior);
            $estado_de_las_ventas->where('fechaVentaCierre', '<=', $ultimoDiaSemestreAnterior);

            $ventas_por_mes->where('fechaVentaCierre', '>=', $primerDiaSemestreAnterior);
            $ventas_por_mes->where('fechaVentaCierre', '<=', $ultimoDiaSemestreAnterior);

            $ventas_por_mes_monto->where('fechaVentaCierre', '>=', $primerDiaSemestreAnterior);
            $ventas_por_mes_monto->where('fechaVentaCierre', '<=', $ultimoDiaSemestreAnterior);

            $fi = $primerDiaSemestreAnterior->format('Y-m-d H:i:s');
            $ff = $ultimoDiaSemestreAnterior->format('Y-m-d H:i:s');
        }


        if ($periodo == "Mes pasado") {

            $contactos_altas->where('created_at', '>=', $fecha_inicial_mes_pasado);
            $contactos_altas->where('created_at', '<=', $fecha_final_mes_pasado);

            $contactos->where('created_at', '>=', $fecha_inicial_mes_pasado);
            $contactos->where('created_at', '<=', $fecha_final_mes_pasado);

            $ventas->where('fechaVentaCierre', '>=', $fecha_inicial_mes_pasado);
            $ventas->where('fechaVentaCierre', '<=', $fecha_final_mes_pasado);

            $fuente_de_las_ventas->where('fechaVentaCierre', '>=', $fecha_inicial_mes_pasado);
            $fuente_de_las_ventas->where('fechaVentaCierre', '<=', $fecha_final_mes_pasado);

            $tipo_de_las_ventas->where('fechaVentaCierre', '>=', $fecha_inicial_mes_pasado);
            $tipo_de_las_ventas->where('fechaVentaCierre', '<=', $fecha_final_mes_pasado);

            $zona_de_las_ventas->where('fechaVentaCierre', '>=', $fecha_inicial_mes_pasado);
            $zona_de_las_ventas->where('fechaVentaCierre', '<=', $fecha_final_mes_pasado);

            $estado_de_las_ventas->where('fechaVentaCierre', '>=', $fecha_inicial_mes_pasado);
            $estado_de_las_ventas->where('fechaVentaCierre', '<=', $fecha_final_mes_pasado);

            $ventas_por_mes->where('fechaVentaCierre', '>=', $fecha_inicial_mes_pasado);
            $ventas_por_mes->where('fechaVentaCierre', '<=', $fecha_final_mes_pasado);

            $ventas_por_mes_monto->where('fechaVentaCierre', '>=', $fecha_inicial_mes_pasado);
            $ventas_por_mes_monto->where('fechaVentaCierre', '<=', $fecha_final_mes_pasado);

            $fi = $fecha_inicial_mes_pasado;
            $ff = $fecha_final_mes_pasado;
        }

        $fuente_de_las_ventas->groupBy(DB::raw('medio_comprador'));

        $tipo_de_las_ventas->groupBy(DB::raw('tipoPropiedad'));

        $zona_de_las_ventas->groupBy(DB::raw('zonaPropiedad'));

        $estado_de_las_ventas->groupBy(DB::raw('estadoPropiedad'));

        $fuente_de_las_ventas = $fuente_de_las_ventas->pluck('CantidadVentas', 'medio_comprador');

        $tipo_de_las_ventas = $tipo_de_las_ventas->pluck('CantidadVentas', 'tipoPropiedad');

        $zona_de_las_ventas = $zona_de_las_ventas->pluck('CantidadVentas', 'zonaPropiedad');

        $estado_de_las_ventas = $estado_de_las_ventas->pluck('CantidadVentas', 'estadoPropiedad');

        $ventas_por_mes_monto = $ventas_por_mes_monto->pluck('total_ventas', 'mes');

        $ventas_por_mes->where(DB::raw('YEAR(ventas.fechaVentaCierre)'), '=', "$ano_actual");

        $ventas_por_mes = $ventas_por_mes->pluck('total_ventas', 'mes');

        $labels_fuente_de_las_ventas = $fuente_de_las_ventas->keys();
        $data_fuente_de_las_ventas = $fuente_de_las_ventas->values();

        $labels_tipo_de_las_ventas = $tipo_de_las_ventas->keys();
        $data_tipo_de_las_ventas = $tipo_de_las_ventas->values();

        $labels_zona_de_las_ventas = $zona_de_las_ventas->keys();
        $data_zona_de_las_ventas = $zona_de_las_ventas->values();

        $labels_estado_de_las_ventas = $estado_de_las_ventas->keys();
        $data_estado_de_las_ventas = $estado_de_las_ventas->values();

        $labels_ventas_por_mes = $ventas_por_mes->keys();
        $data_ventas_por_mes = $ventas_por_mes->values();

        $labels_ventas_por_mes_monto = $ventas_por_mes_monto->keys();
        $data_ventas_por_mes_monto = $ventas_por_mes_monto->values();

        $ventas = $ventas->first();

        $contactos = $contactos->first();

        $contactos_altas = $contactos_altas->first();

        return view("admin.dashboard.dashboardasesor", compact('ventas', 'data_fuente_de_las_ventas', 'labels_fuente_de_las_ventas', 'data_tipo_de_las_ventas', 'labels_tipo_de_las_ventas', 'data_zona_de_las_ventas', 'labels_zona_de_las_ventas', 'data_estado_de_las_ventas', 'labels_estado_de_las_ventas', 'data_ventas_por_mes', 'labels_ventas_por_mes', 'data_ventas_por_mes_monto', 'labels_ventas_por_mes_monto', 'periodo', 'contactos', 'contactos_altas', 'fi', 'ff'));
    }
}
