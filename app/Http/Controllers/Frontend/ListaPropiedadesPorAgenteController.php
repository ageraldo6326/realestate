<?php

namespace App\Http\Controllers\Frontend;


use App\Models\User;
use App\Services\CatalogoService;
use App\Services\InmobiliariaService;
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
        $inmobiliaria = InmobiliariaService::get();

        $portadas = CatalogoService::portadas();

        $zonas = CatalogoService::zonas();

        $disponibles_para = CatalogoService::disponiblePara();

        $tipos_propiedades = CatalogoService::tipos();

        $usuario = User::where('id',$id)->first();

        if (!$usuario) {
            abort(404);
        }

        $propiedades = DB::table('propiedads')
        ->select('estado_id','estado','propiedads.id', 'referencia', 'telefono', 'foto_portada', 'provincia','zona_id', 'zona', 'direccion', 'precio', 'propiedads.titulo', 'slug' ,'propiedads.descripcion_corta', 'propiedads.descripcion', 'propiedads.metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'propiedads.disponible_para' ,'disponible_paras.disponible_para' , 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'propiedads.metadescription', 'propiedads.created_at', 'propiedads.updated_at')
        ->leftJoin('zonas','propiedads.zona_id','=','zonas.id')
        ->leftJoin('estados','propiedads.estado_id','=','estados.id')
        ->leftJoin('disponible_paras','propiedads.disponible_para','=','disponible_paras.id')
        ->leftJoin('users','propiedads.asignada_a_id','=','users.id')
        ->orderBy('propiedads.created_at','desc')
        ->where('propiedads.asignada_a_id', $usuario->id)
        ->whereNull('users.deleted_at')
        ->where('activa',1)
        ->paginate(3);

        return view('frontend.propiedades', compact('portadas','zonas','disponibles_para','tipos_propiedades','propiedades','inmobiliaria'));

    }

}
