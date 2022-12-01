<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Propiedad;
use App\Models\Inmobiliaria;
use Illuminate\Http\Request;
use App\Models\TiposDePropiedad;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Productdetails extends Controller
{
    //

    public function show($id) {

        $inmobiliaria = Inmobiliaria::first();

        $propiedad_click = Propiedad::where('id',$id)->first();

        $propiedad_click->clicks++;
        
        $propiedad_click->save();

        $propiedad = DB::table('propiedads')
        ->select('propiedads.id', 'foto_portada', 'provincia', 'zona_id', 'zona', 'tipos_de_propiedads.tipo', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at')
        ->leftJoin('zonas','propiedads.zona_id','=','zonas.id')
        ->leftJoin('tipos_de_propiedads','propiedads.tipo','=','tipos_de_propiedads.id')
        ->where('propiedads.id','=',$id)
        ->first();        

        $tipo_de_propiedades = TiposDePropiedad::all();

        return view("frontend.product-details",compact("propiedad","tipo_de_propiedades","inmobiliaria"));
    }
}
