<?php

namespace App\Services;

use App\Models\Disponible_para;
use App\Models\Barrio;
use App\Models\Enfoque;
use App\Models\Estados;
use App\Models\Portada;
use App\Models\Post;
use App\Models\provincia as ProvinciaModel;
use App\Models\Sector;
use App\Models\Testimonio;
use App\Models\TiposDePropiedad;
use App\Models\User;
use App\Models\Zonas;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CatalogoService
{
    public static function zonas(): Collection
    {
        return Cache::remember('catalogo.zonas', now()->addHours(6), function () {
            return Zonas::query()->orderBy('zona')->get();
        });
    }

    public static function provincias(): Collection
    {
        return Cache::remember('catalogo.provincias', now()->addHours(6), function () {
            return ProvinciaModel::query()->orderBy('provincia')->get();
        });
    }

    public static function sectores(): Collection
    {
        return Cache::remember('catalogo.sectores', now()->addHours(6), function () {
            return Sector::query()->orderBy('sector')->get();
        });
    }

    public static function barrios(): Collection
    {
        return Cache::remember('catalogo.barrios', now()->addHours(6), function () {
            return Barrio::query()->orderBy('barrio')->get();
        });
    }

    public static function tipos(): Collection
    {
        return Cache::remember('catalogo.tipos_propiedad', now()->addHours(6), function () {
            return TiposDePropiedad::query()->orderBy('tipo')->get();
        });
    }

    public static function estados(): Collection
    {
        return Cache::remember('catalogo.estados', now()->addHours(6), function () {
            return Estados::query()->orderBy('estado')->get();
        });
    }

    public static function disponiblePara(): Collection
    {
        return Cache::remember('catalogo.disponible_para', now()->addHours(6), function () {
            return Disponible_para::query()->get();
        });
    }

    public static function portadas(): Collection
    {
        return Cache::remember('catalogo.portadas', now()->addHours(6), function () {
            return Portada::query()->get();
        });
    }

    public static function testimonios(): Collection
    {
        return Cache::remember('catalogo.testimonios', now()->addHours(6), function () {
            return Testimonio::query()->get();
        });
    }

    public static function enfoques(): Collection
    {
        return Cache::remember('catalogo.enfoques', now()->addHours(6), function () {
            return Enfoque::query()->get();
        });
    }

    public static function posts(): Collection
    {
        return Cache::remember('catalogo.posts', now()->addMinutes(30), function () {
            return Post::query()->latest()->get();
        });
    }

    public static function asesoresActivos(): Collection
    {
        return Cache::remember('catalogo.asesores_activos', now()->addMinutes(30), function () {
            return User::query()
                ->select('id', 'name', 'email', 'foto', 'activo')
                ->where('activo', 1)
                ->orderBy('name')
                ->get();
        });
    }

    public static function forgetAll(): void
    {
        Cache::forget('catalogo.zonas');
        Cache::forget('catalogo.provincias');
        Cache::forget('catalogo.sectores');
        Cache::forget('catalogo.barrios');
        Cache::forget('catalogo.tipos_propiedad');
        Cache::forget('catalogo.estados');
        Cache::forget('catalogo.disponible_para');
        Cache::forget('catalogo.portadas');
        Cache::forget('catalogo.testimonios');
        Cache::forget('catalogo.enfoques');
        Cache::forget('catalogo.posts');
        Cache::forget('catalogo.asesores_activos');
    }
}
