<?php

namespace Tests\Feature;

use App\Models\Inmobiliaria;
use Tests\TestCase;

class InmobiliariaAssetUrlTest extends TestCase
{
    public function test_resuelve_logo_legacy_como_url_publica_absoluta(): void
    {
        $company = new Inmobiliaria(['logo' => 'inmobiliaria/logo.png']);

        $this->assertSame(
            url('/assets/inmobiliaria/logo.png'),
            $company->publicLogoUrl()
        );
    }

    public function test_conserva_las_rutas_publicas_de_los_logos_nuevos(): void
    {
        $company = new Inmobiliaria([
            'logo' => '/img/logo-abcd1234.png',
            'favicon' => 'https://cdn.example.test/favicon.png',
        ]);

        $this->assertSame(url('/img/logo-abcd1234.png'), $company->publicLogoUrl());
        $this->assertSame('https://cdn.example.test/favicon.png', $company->publicFaviconUrl());
    }
}
