<?php

namespace App\Http\Controllers;

use App\Models\Zonas;
use App\Models\TiposDePropiedad;
use App\Services\InmobiliariaService;

class propiedadPorZonaController extends Controller
{

    public function index($zona)
    {   $zona = str_replace('-', ' ', $zona);
        $zona = Zonas::where('zona',$zona)->first();
        $inmobiliaria = InmobiliariaService::get();
    
        if ($zona) {
            $zona_id = $zona->id;   

            $inmobiliaria = InmobiliariaService::get();
            
            return view('frontend.PropiedadesPorZona', compact('zona_id','zona','inmobiliaria'));

        } else {
            return view('errors.404',compact('inmobiliaria'));
        }
    }

    public function tipo($tipo)
    {   $tipo = str_replace('-', ' ', $tipo);
        $tipo = TiposDePropiedad::where('tipo',$tipo)->first();
        $inmobiliaria = InmobiliariaService::get();

        if ($tipo) {

            $tipo_id = $tipo->id;   

            $inmobiliaria = InmobiliariaService::get();
            
            return view('frontend.PropiedadesPorTipo', compact('tipo_id','tipo','inmobiliaria'));

        } else {
            return view('errors.404',compact('inmobiliaria'));
        }
    }    
}
