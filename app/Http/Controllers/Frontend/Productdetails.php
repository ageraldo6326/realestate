<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Propiedad;
use App\Services\InmobiliariaService;
use App\Services\SeoMetadataService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;

class Productdetails extends Controller
{
    //

    public function show(string $slug, SeoMetadataService $seoMetadataService)
    {
        $inmobiliaria = InmobiliariaService::get();

        $propiedad = DB::table('propiedads')
            ->select('estado_id', 'estado', 'propiedads.id', 'propiedads.slug', 'referencia', 'foto_portada', 'provincia', 'zona_id', 'zona', 'zonas.slug as zona_slug', 'zonas.is_public as zona_publica', 'tipos_de_propiedads.tipo', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'asignada_a_id', 'captada_por', 'foto_vendedor', 'disponible_paras.disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at')
            ->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id')
            ->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id')
            ->leftJoin('tipos_de_propiedads', 'propiedads.tipo', '=', 'tipos_de_propiedads.id')
            ->leftJoin('disponible_paras', 'propiedads.disponible_para', '=', 'disponible_paras.id')
            ->where('propiedads.slug', $slug)
            ->where('propiedads.activa', true)
            ->where('propiedads.aprobada', true)
            ->where('propiedads.vendida', false)
            ->first();

        if ($propiedad) {
            Propiedad::query()->where('slug', $slug)->increment('clicks');

            $propiedades_relacionadas = $this->relatedProperties(
                (int) $propiedad->id,
                $propiedad->zona_id === null ? null : (int) $propiedad->zona_id
            );

            $tipo_de_propiedades = DB::table('propiedads')
                ->leftJoin('tipos_de_propiedads', 'propiedads.tipo', '=', 'tipos_de_propiedads.id')
                ->select('tipos_de_propiedads.tipo', DB::raw('count(propiedads.id) as cantidad'))
                ->groupBy('tipos_de_propiedads.tipo')
                ->orderBy('tipos_de_propiedads.tipo')
                ->get();

            $usuario = null;

            if (!empty($propiedad->asignada_a_id)) {
                $usuario = User::query()->find((int) $propiedad->asignada_a_id);
            }

            if (!$usuario && !empty($propiedad->asignada_a)) {
                $usuario = User::query()->where('email', (string) $propiedad->asignada_a)->first();
            }

            $seo = $seoMetadataService->forProperty($propiedad, $inmobiliaria);

            return view("frontend.propiedad", compact("propiedad", "tipo_de_propiedades", "inmobiliaria", "usuario", "propiedades_relacionadas", "seo"));
        }

        abort(404);
    }

    protected function relatedProperties(int $propertyId, ?int $zoneId): Collection
    {
        return Propiedad::query()
            ->select([
                'propiedads.id',
                'propiedads.slug',
                'propiedads.foto_portada',
                'propiedads.titulo',
                'propiedads.habitaciones',
                'propiedads.banos',
                'propiedads.Moneda',
                'propiedads.precio',
                'propiedads.metraje',
                'propiedads.updated_at',
                'estados.estado',
                'zonas.zona',
            ])
            ->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id')
            ->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id')
            ->publiclyVisible()
            ->where('propiedads.id', '<>', $propertyId)
            ->where('propiedads.zona_id', $zoneId)
            ->limit(2)
            ->get();
    }

    public function legacyRedirect(string $slug): RedirectResponse
    {
        abort_unless(
            Propiedad::query()->publiclyVisible()->where('slug', $slug)->exists(),
            404
        );

        return redirect()->route('propiedad', ['slug' => $slug], 301);
    }
}
