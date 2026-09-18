<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Propiedad;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\CatalogoService;
use App\Services\InmobiliariaService;
use App\Services\SeoMetadataService;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //

    public function index(SeoMetadataService $seoMetadata)
    {
        $inmobiliaria = InmobiliariaService::get();

        $portadas = CatalogoService::portadas();

        $testimonios = CatalogoService::testimonios();

        $enfoques = CatalogoService::enfoques();

        $posts = Post::query()
            ->select('id', 'titulo', 'slug', 'foto', 'autor', 'created_at')
            ->published()
            ->latest()
            ->limit(6)
            ->get();

        $pro_destacadas = Propiedad::query()->publiclyVisible();

        $pro_destacadas->select(
            'propiedads.id',
            'propiedads.referencia',
            'propiedads.foto_portada',
            'propiedads.ciudad',
            'barrios.barrio as barrio_nombre',
            'sectores.sector as sector_nombre',
            'provincias.provincia as provincia_nombre',
            'propiedads.precio',
            'propiedads.titulo',
            'propiedads.slug',
            'propiedads.descripcion_corta',
            'propiedads.habitaciones',
            'propiedads.banos',
            'propiedads.parqueos',
            'propiedads.metraje',
            'disponible_paras.disponible_para',
            'propiedads.Moneda',
            'propiedads.updated_at',
            DB::raw('COALESCE(assigned_user.name, creator_user.name) as asesor_nombre'),
            DB::raw('COALESCE(assigned_user.telefono, creator_user.telefono) as asesor_telefono'),
            DB::raw('COALESCE(assigned_user.foto, creator_user.foto) as asesor_foto')
        );
        $pro_destacadas->leftJoin('sectores', 'propiedads.sector_id', '=', 'sectores.id');
        $pro_destacadas->leftJoin('barrios', 'propiedads.barrio_id', '=', 'barrios.id');
        $pro_destacadas->leftJoin('provincias', 'propiedads.provincia', '=', 'provincias.id');
        $pro_destacadas->leftJoin('users as assigned_user', 'propiedads.asignada_a_id', '=', 'assigned_user.id');
        $pro_destacadas->leftJoin('users as creator_user', 'propiedads.captada_por', '=', 'creator_user.id');
        $pro_destacadas->leftJoin('disponible_paras', 'propiedads.disponible_para', '=', 'disponible_paras.id');
        $pro_destacadas->where('destacada', '=', 1);
        $pro_destacadas->whereNull('assigned_user.deleted_at');
        $pro_destacadas->limit(3);
        $pro_destacadas->orderBy('propiedads.created_at', 'desc');

        $pro_destacadas = $pro_destacadas->get();
        $seo = $seoMetadata->forHome($inmobiliaria);

        return view('frontend.home', compact('portadas', 'pro_destacadas', 'testimonios', 'inmobiliaria', 'enfoques', 'posts', 'seo'));
    }

    public function Buscar($tabla, $campo, $valor)
    {
        $nombre = $tabla::select($campo)->where('id', $valor)->get();
        return $nombre;
    }
}
