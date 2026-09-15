<?php

namespace Tests\Feature;

use App\Models\Inmobiliaria;
use App\Services\InmobiliariaService;
use App\Services\SeoMetadataService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class SiteSeoConfigurationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'seo.canonical_url' => 'https://fallback.example.test',
            'seo.indexing_enabled' => false,
        ]);
        DB::purge('sqlite');
        DB::reconnect('sqlite');
        DB::setDefaultConnection('sqlite');
        Cache::flush();

        Schema::create('inmobiliarias', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('titulo')->nullable();
            $table->string('dominio')->nullable();
            $table->string('seo_canonical_url')->nullable();
            $table->json('seo_alternate_hosts')->nullable();
            $table->boolean('seo_indexable')->default(false);
            $table->string('social_image')->nullable();
            $table->string('search_console_verification_token')->nullable();
            $table->timestamps();
        });
    }

    public function test_site_configuration_controls_canonical_indexing_and_search_console_metadata(): void
    {
        $company = Inmobiliaria::query()->create([
            'nombre' => 'ALIS Demo',
            'seo_canonical_url' => 'https://realestate.voipcom.net/',
            'seo_alternate_hosts' => ['www.realestate.voipcom.net'],
            'seo_indexable' => true,
            'social_image' => '/img/social.png',
            'search_console_verification_token' => 'google-token_123',
        ]);
        InmobiliariaService::forget();

        $this->assertSame('https://realestate.voipcom.net', InmobiliariaService::canonicalUrl($company));
        $this->assertSame(
            ['realestate.voipcom.net', 'www.realestate.voipcom.net'],
            InmobiliariaService::publicHosts($company)
        );

        $seo = app(SeoMetadataService::class)->forHome($company);

        $this->assertSame('https://realestate.voipcom.net/', $seo['canonical']);
        $this->assertSame('index, follow', $seo['robots']);
        $this->assertSame('https://realestate.voipcom.net/img/social.png', $seo['image']);

        $html = view('layout.encabezado-landing', [
            'inmo' => $company,
            'frontendTheme' => [],
            'seo' => $seo,
        ])->render();

        $this->assertStringContainsString('name="google-site-verification" content="google-token_123"', $html);
        $this->assertStringContainsString('href="https://realestate.voipcom.net/"', $html);
    }

    public function test_robots_allows_only_the_configured_canonical_host(): void
    {
        Inmobiliaria::query()->create([
            'seo_canonical_url' => 'https://realestate.voipcom.net',
            'seo_indexable' => true,
        ]);
        InmobiliariaService::forget();

        $this->get('https://realestate.voipcom.net/robots.txt')
            ->assertOk()
            ->assertSee('Allow: /', false)
            ->assertSee('Sitemap: https://realestate.voipcom.net/sitemap.xml', false);

        $this->get('https://www.realestate.voipcom.net/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /', false)
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_site_settings_form_renders_domain_and_indexing_controls(): void
    {
        $html = view('admin.empresa.partials.form-fields', [
            'inmobiliaria' => null,
            'errors' => new ViewErrorBag(),
        ])->render();

        $this->assertStringContainsString('name="seo_canonical_url"', $html);
        $this->assertStringContainsString('name="seo_alternate_hosts"', $html);
        $this->assertStringContainsString('name="seo_indexable"', $html);
        $this->assertStringContainsString('name="search_console_verification_token"', $html);
        $this->assertStringContainsString('name="social_image"', $html);
    }
}
