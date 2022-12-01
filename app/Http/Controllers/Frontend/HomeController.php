<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Zonas;
use App\Models\Portada;
use App\Models\Propiedad;
use App\Models\Testimonio;
use App\Models\Inmobiliaria;
use Illuminate\Http\Request;
use App\Models\Disponible_para;
use App\Models\EstatusPropiedad;
use App\Models\TiposDePropiedad;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Enfoque;
use App\Models\Post;

class HomeController extends Controller
{
    //

    public function index() {
        $inmobiliaria = Inmobiliaria::first();

        $portadas = Portada::all();

        $zonas = Zonas::all();

        $disponibles_para = Disponible_para::all();

        $tipos_propiedades = TiposDePropiedad::all();

        $testimonios = Testimonio::all();

        $enfoques = Enfoque::all();

        $posts = Post::all();

        // $propiedades = Propiedad::where('destacada',1)->Orderby('clicks','desc')->get();

        $propiedades = DB::table('propiedads')
        ->select('propiedads.id', 'foto_portada', 'provincia', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at')
        ->leftJoin('zonas','propiedads.zona_id','=','zonas.id')
        ->orderBy('clicks','desc')
        ->get();

        return view('frontend.home', compact('portadas','zonas','disponibles_para','tipos_propiedades','propiedades','testimonios','inmobiliaria','enfoques','posts'));

    }

    public function Buscar($tabla,$campo,$valor) {
        $nombre = $tabla::select($campo)->where('id',$valor)->get();
        return $nombre;
    }
}
