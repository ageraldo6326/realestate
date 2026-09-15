<?php

namespace App\Http\Controllers;

use App\Models\Zonas;
use App\Models\TiposDePropiedad;
use App\Services\InmobiliariaService;
use App\Models\Propiedad;
use App\Services\SeoMetadataService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class propiedadPorZonaController extends Controller
{

    public function index(string $zona, Request $request, SeoMetadataService $seoMetadataService)
    {
        $zona = Zonas::query()->where('slug', $zona)->where('is_public', true)->firstOrFail();
        $inmobiliaria = InmobiliariaService::get();
        $hasListings = Propiedad::query()->publiclyVisible()->where('zona_id', $zona->id)->exists();

        abort_unless($hasListings || filled($zona->seo_description), 404);

        $zona_id = $zona->id;
        $seo = $seoMetadataService->forZone($zona, $inmobiliaria, (int) $request->query('page', 1));

        return view('frontend.PropiedadesPorZona', compact('zona_id', 'zona', 'inmobiliaria', 'seo'));
    }

    public function legacyRedirect(string $zona): RedirectResponse
    {
        $zone = Zonas::query()->where('slug', $zona)->where('is_public', true)->firstOrFail();
        $hasListings = Propiedad::query()->publiclyVisible()->where('zona_id', $zone->id)->exists();

        abort_unless($hasListings || filled($zone->seo_description), 404);

        return redirect()->route('propiedadesPorZona', ['zona' => $zone->slug], 301);
    }

    public function tipo($tipo, SeoMetadataService $seoMetadataService)
    {   $tipo = str_replace('-', ' ', $tipo);
        $tipo = TiposDePropiedad::where('tipo',$tipo)
            ->whereHas('propiedades', function ($query): void {
                $query->publiclyVisible();
            })
            ->firstOrFail();
        $inmobiliaria = InmobiliariaService::get();
        $tipo_id = $tipo->id;
        $seo = $seoMetadataService->forType($tipo, $inmobiliaria);

        return view('frontend.PropiedadesPorTipo', compact('tipo_id','tipo','inmobiliaria', 'seo'));
    }    
}
