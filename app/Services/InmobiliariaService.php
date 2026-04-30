<?php

namespace App\Services;

use App\Models\Inmobiliaria;
use Illuminate\Support\Facades\Cache;

class InmobiliariaService
{
    public static function get(): ?Inmobiliaria
    {
        return Cache::remember('inmobiliaria.config', now()->addMinutes(60), function () {
            return Inmobiliaria::query()->first();
        });
    }

    public static function forget(): void
    {
        Cache::forget('inmobiliaria.config');
    }
}
