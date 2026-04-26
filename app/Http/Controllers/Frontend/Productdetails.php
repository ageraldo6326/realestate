<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Propiedad;
use App\Models\Inmobiliaria;
use Illuminate\Http\Request;
use App\Models\TiposDePropiedad;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Productdetails extends Controller
{
    //

    public function show($id) {

        

        $propiedad_click = Propiedad::where('slug',$id)->first();

        if ($propiedad_click) {

            $inmobiliaria = Inmobiliaria::first();   

            $propiedad_click->clicks++;
            
            $propiedad_click->save();

            $propiedad = DB::table('propiedads')
            ->select('estado_id','estado','propiedads.id','referencia', 'foto_portada', 'provincia', 'zona_id', 'zona', 'tipos_de_propiedads.tipo', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'foto_vendedor', 'disponible_paras.disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at')
            ->leftJoin('zonas','propiedads.zona_id','=','zonas.id')
            ->leftJoin('estados','propiedads.estado_id','=','estados.id')
            ->leftJoin('tipos_de_propiedads','propiedads.tipo','=','tipos_de_propiedads.id')
            ->leftJoin('disponible_paras','propiedads.disponible_para','=','disponible_paras.id')
            ->where('propiedads.slug','=',$id)
            ->first();    
            
            $propiedades_relacionadas = DB::table('propiedads')
            ->select('estado_id','estado','propiedads.id', 'referencia', 'foto_portada', 'provincia', 'slug','zona_id', 'zona', 'tipos_de_propiedads.tipo', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'foto_vendedor', 'disponible_paras.disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at')
            ->leftJoin('zonas','propiedads.zona_id','=','zonas.id')
            ->leftJoin('estados','propiedads.estado_id','=','estados.id')
            ->leftJoin('tipos_de_propiedads','propiedads.tipo','=','tipos_de_propiedads.id')
            ->leftJoin('disponible_paras','propiedads.disponible_para','=','disponible_paras.id')
            ->whereNotIn('propiedads.id',[$id])
            ->Where('zona_id',$propiedad->zona_id)
            ->limit(2)
            ->get();         

            $tipo_de_propiedades = DB::table('propiedads')
            ->leftJoin('tipos_de_propiedads', 'propiedads.tipo', '=', 'tipos_de_propiedads.id')
            ->select('tipos_de_propiedads.tipo', DB::raw('count(propiedads.id) as cantidad'))
            ->groupBy('tipos_de_propiedads.tipo')
            ->orderBy('tipos_de_propiedads.tipo')
            ->get();

            $usuario = User::where('email',$propiedad->asignada_a)->first();

            return view("frontend.propiedad",compact("propiedad","tipo_de_propiedades","inmobiliaria","usuario","propiedades_relacionadas"));

        } else {
            return redirect()->route('listapropiedades');
        }
    }
}
