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

        $pro_destacadas = Propiedad::query();

        $pro_destacadas->select('name', 'foto', 'estado_id', 'telefono', 'estado', 'propiedads.id', 'referencia', 'foto_portada', 'provincia', 'zona_id', 'zona', 'direccion', 'precio', 'propiedads.titulo', 'slug', 'descripcion_corta', 'propiedads.descripcion', 'propiedads.metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'propiedads.disponible_para', 'disponible_paras.disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'propiedads.metadescription', 'propiedads.created_at', 'propiedads.updated_at');
        $pro_destacadas->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id');
        $pro_destacadas->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id');
        $pro_destacadas->leftJoin('users', 'propiedads.asignada_a', '=', 'users.email');
        $pro_destacadas->leftJoin('disponible_paras', 'propiedads.disponible_para', '=', 'disponible_paras.id');
        $pro_destacadas->where('destacada','=',1);
        $pro_destacadas->where('activa','=',1);
        $pro_destacadas->limit(3);
        if (optional($inmobiliaria)->aprobacion === "on") {
            $pro_destacadas->where('aprobada', 1);
        }
        $pro_destacadas->orderBy('created_at', 'desc');
        
        $pro_destacadas = $pro_destacadas->get(); 

        return view('frontend.home', compact('portadas','zonas','pro_destacadas', 'disponibles_para','tipos_propiedades','testimonios','inmobiliaria','enfoques','posts'));

    }

    public function Buscar($tabla,$campo,$valor) {
        $nombre = $tabla::select($campo)->where('id',$valor)->get();
        return $nombre;
    }
}
