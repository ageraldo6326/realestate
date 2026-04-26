<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Zonas;
use App\Models\Enfoque;
use App\Models\Testimonio;
use App\Models\Inmobiliaria;
use Illuminate\Http\Request;
use App\Models\Disponible_para;
use App\Models\TiposDePropiedad;

class propiedadPorZonaController extends Controller
{

    public function index($zona)
    {   $zona = str_replace('-', ' ', $zona);
        $zona = Zonas::where('zona',$zona)->first();
        $inmobiliaria = Inmobiliaria::first();
    
        if ($zona) {
            $zona_id = $zona->id;   

            $inmobiliaria = Inmobiliaria::first();
            
            return view('frontend.PropiedadesPorZona', compact('zona_id','zona','inmobiliaria'));

        } else {
            return view('errors.404',compact('inmobiliaria'));
        }
    }

    public function tipo($tipo)
    {   $tipo = str_replace('-', ' ', $tipo);
        $tipo = TiposDePropiedad::where('tipo',$tipo)->first();
        $inmobiliaria = Inmobiliaria::first();

        if ($tipo) {

            $tipo_id = $tipo->id;   

            $inmobiliaria = Inmobiliaria::first();
            
            return view('frontend.PropiedadesPorTipo', compact('tipo_id','tipo','inmobiliaria'));

        } else {
            return view('errors.404',compact('inmobiliaria'));
        }
    }    
}
