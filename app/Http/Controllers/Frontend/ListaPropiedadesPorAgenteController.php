<?php

namespace App\Http\Controllers\Frontend;


use App\Models\User;
use App\Models\Zonas;
use App\Models\Portada;
use App\Models\Propiedad;
use App\Models\Inmobiliaria;
use Illuminate\Http\Request;
use App\Models\Disponible_para;
use App\Models\TiposDePropiedad;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ListaPropiedadesPorAgenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $inmobiliaria = Inmobiliaria::first();

        $portadas = Portada::all();

        $zonas = Zonas::all();

        $disponibles_para = Disponible_para::all();

        $tipos_propiedades = TiposDePropiedad::all();

        $usuario = User::where('id',$id)->first();

        $propiedades = DB::table('propiedads')
        ->select('estado_id','estado','propiedads.id', 'referencia', 'telefono', 'foto_portada', 'provincia','zona_id', 'zona', 'direccion', 'precio', 'propiedads.titulo', 'slug' ,'propiedads.descripcion_corta', 'propiedads.descripcion', 'propiedads.metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'propiedads.disponible_para' ,'disponible_paras.disponible_para' , 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'propiedads.metadescription', 'propiedads.created_at', 'propiedads.updated_at')
        ->leftJoin('zonas','propiedads.zona_id','=','zonas.id')
        ->leftJoin('estados','propiedads.estado_id','=','estados.id')
        ->leftJoin('disponible_paras','propiedads.disponible_para','=','disponible_paras.id')
        ->leftJoin('users','propiedads.asignada_a','=','users.email')
        ->orderBy('created_at','desc')
        ->where('asignada_a',$usuario->email)
        ->where('activa',1)
        ->paginate(3);

        return view('frontend.propiedades', compact('portadas','zonas','disponibles_para','tipos_propiedades','propiedades','inmobiliaria'));

    }

}
