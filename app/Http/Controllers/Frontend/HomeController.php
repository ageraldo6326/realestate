<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Propiedad;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\CatalogoService;
use App\Services\InmobiliariaService;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //

    public function index()
    {
        $inmobiliaria = InmobiliariaService::get();

        $portadas = CatalogoService::portadas();

        $provincias = CatalogoService::provincias();
        $sectores = CatalogoService::sectores();

        $disponibles_para = CatalogoService::disponiblePara();

        $tipos_propiedades = CatalogoService::tipos();

        $testimonios = CatalogoService::testimonios();

        $enfoques = CatalogoService::enfoques();

        $posts = Post::query()
            ->select('id', 'titulo', 'slug', 'foto', 'autor', 'created_at')
            ->where('activo', 1)
            ->latest()
            ->limit(6)
            ->get();

        $pro_destacadas = Propiedad::query();

        $pro_destacadas->select(
            'propiedads.estado_id',
            'estados.estado',
            'propiedads.id',
            'propiedads.referencia',
            'propiedads.foto_portada',
            'propiedads.provincia',
            'propiedads.ciudad',
            'propiedads.sector_id',
            'barrios.barrio as barrio_nombre',
            'sectores.sector as sector_nombre',
            'provincias.provincia as provincia_nombre',
            'propiedads.direccion',
            'propiedads.precio',
            'propiedads.titulo',
            'propiedads.slug',
            'propiedads.descripcion_corta',
            'propiedads.descripcion',
            'propiedads.metadescripcion',
            'propiedads.habitaciones',
            'propiedads.banos',
            'propiedads.parqueos',
            'propiedads.metraje',
            'propiedads.metraje_construccion',
            'propiedads.asignada_a',
            'propiedads.captada_por',
            'propiedads.tipo',
            'propiedads.foto_vendedor',
            'propiedads.disponible_para',
            'disponible_paras.disponible_para',
            'destacada',
            'foto1',
            'foto2',
            'foto3',
            'foto4',
            'video1',
            'video2',
            'video3',
            'video4',
            'Moneda',
            'vendida',
            'lobby',
            'plantaelectrica',
            'camaravigilancia',
            'escaleraemergencia',
            'maderapreciosa',
            'balcon',
            'walkincloset',
            'jacuzzi',
            'areainfantil',
            'banovisitas',
            'cisterna',
            'inversorareacomun',
            'gascomun',
            'gazebo',
            'pozo',
            'piscina',
            'familyroom',
            'cuartodeservicio',
            'patio',
            'portonelectrico',
            'seguridad24horas',
            'ascensor',
            'parqueostechados',
            'preinstalacionairetinacoinversor',
            'terraza',
            'estudio',
            'gimnasio',
            'controldeacceso',
            'clicks',
            'propiedads.metadescription',
            'propiedads.created_at',
            'propiedads.updated_at',
            DB::raw('COALESCE(assigned_user.name, creator_user.name) as asesor_nombre'),
            DB::raw('COALESCE(assigned_user.telefono, creator_user.telefono) as asesor_telefono'),
            DB::raw('COALESCE(assigned_user.foto, creator_user.foto) as asesor_foto')
        );
        $pro_destacadas->leftJoin('sectores', 'propiedads.sector_id', '=', 'sectores.id');
        $pro_destacadas->leftJoin('barrios', 'propiedads.barrio_id', '=', 'barrios.id');
        $pro_destacadas->leftJoin('provincias', 'propiedads.provincia', '=', 'provincias.id');
        $pro_destacadas->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id');
        $pro_destacadas->leftJoin('users as assigned_user', 'propiedads.asignada_a_id', '=', 'assigned_user.id');
        $pro_destacadas->leftJoin('users as creator_user', 'propiedads.captada_por', '=', 'creator_user.id');
        $pro_destacadas->leftJoin('disponible_paras', 'propiedads.disponible_para', '=', 'disponible_paras.id');
        $pro_destacadas->where('destacada', '=', 1);
        $pro_destacadas->where('activa', '=', 1);
        $pro_destacadas->whereNull('assigned_user.deleted_at');
        $pro_destacadas->limit(3);
        if ((bool) optional($inmobiliaria)->aprobacion) {
            $pro_destacadas->where('aprobada', 1);
        }
        $pro_destacadas->orderBy('propiedads.created_at', 'desc');

        $pro_destacadas = $pro_destacadas->get();

        return view('frontend.home', compact('portadas', 'provincias', 'sectores', 'pro_destacadas', 'disponibles_para', 'tipos_propiedades', 'testimonios', 'inmobiliaria', 'enfoques', 'posts'));
    }

    public function Buscar($tabla, $campo, $valor)
    {
        $nombre = $tabla::select($campo)->where('id', $valor)->get();
        return $nombre;
    }
}
