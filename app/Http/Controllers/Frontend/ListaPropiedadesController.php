<?php

namespace App\Http\Controllers\Frontend;

use App\Services\CatalogoService;
use App\Services\InmobiliariaService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListaPropiedadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inmobiliaria = InmobiliariaService::get();

        $portadas = CatalogoService::portadas();

        $zonas = CatalogoService::zonas();

        $disponibles_para = CatalogoService::disponiblePara();

        $tipos_propiedades = CatalogoService::tipos();

        // if ($request->criterio=="") {
        //     $propiedades = DB::table('propiedads')
        //     ->select('estado_id','estado','propiedads.id','referencia','foto_portada', 'provincia','zona_id', 'zona', 'direccion', 'precio', 'propiedads.titulo','slug', 'propiedads.descripcion_corta', 'propiedads.descripcion', 'propiedads.metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'propiedads.disponible_para' ,'disponible_paras.disponible_para' , 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'propiedads.metadescription', 'propiedads.created_at', 'propiedads.updated_at','telefono')
        //     ->where('propiedads.aprobada','=',1)
        //     ->leftJoin('zonas','propiedads.zona_id','=','zonas.id')
        //     ->leftJoin('estados','propiedads.estado_id','=','estados.id')
        //     ->leftJoin('disponible_paras','propiedads.disponible_para','=','disponible_paras.id')
        //     ->leftJoin('users','propiedads.asignada_a','=','users.email')
        //     ->orderBy('created_at','desc')
        //     ->paginate(20);
        // } else {

        //     $propiedades = DB::table('propiedads')
        //     ->select('estado_id','estado','propiedads.id', 'referencia', 'foto_portada', 'provincia','zona_id', 'zona', 'direccion', 'precio', 'propiedads.titulo','slug', 'propiedads.descripcion_corta', 'propiedads.descripcion', 'propiedads.metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'propiedads.disponible_para' ,'disponible_paras.disponible_para' , 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'propiedads.metadescription', 'propiedads.created_at', 'propiedads.updated_at','telefono')
        //     ->leftJoin('zonas','propiedads.zona_id','=','zonas.id')
        //     ->leftJoin('estados','propiedads.estado_id','=','estados.id')
        //     ->leftJoin('users','propiedads.asignada_a','=','users.email')
        //     ->leftJoin('disponible_paras','propiedads.disponible_para','=','disponible_paras.id')
        //     ->orderBy('created_at','desc')
        //     ->where('propiedads.titulo',"like","%$request->criterio%")
        //     ->Orwhere('propiedads.id',$request->criterio)
        //     ->Orwhere('zona','like',"%$request->criterio%")
        //     ->where('activa',1)
        //     ->paginate(20);
        // };        

        // Las propiedades se cargan via Livewire con paginacion y filtros para evitar cargas masivas.
        $propiedades = collect();

        return view('frontend.propiedades', compact('portadas', 'zonas', 'disponibles_para', 'tipos_propiedades', 'propiedades', 'inmobiliaria'));
    }
}
