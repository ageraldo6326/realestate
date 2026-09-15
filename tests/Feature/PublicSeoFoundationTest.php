<?php

namespace Tests\Feature;

use App\Models\Propiedad;
use App\Services\SeoMetadataService;
use Tests\TestCase;

class PublicSeoFoundationTest extends TestCase
{
    public function test_public_routes_generate_the_new_canonical_structure(): void
    {
        config(['app.url' => 'http://localhost']);

        $this->assertSame('http://localhost/propiedades/apartamento-piantini', route('propiedad', 'apartamento-piantini'));
        $this->assertSame('http://localhost/propiedades/zona/piantini', route('propiedadesPorZona', 'piantini'));
        $this->assertSame('http://localhost/blog/guia-compra', route('post.show', 'guia-compra'));
    }

    public function test_metadata_uses_configured_domain_and_emits_product_schema(): void
    {
        config([
            'seo.canonical_url' => 'https://www.merkelbienesraices.com.do',
            'seo.indexing_enabled' => true,
        ]);

        $property = new Propiedad([
            'slug' => 'apartamento-piantini',
            'titulo' => 'Apartamento en Piantini',
            'descripcion_corta' => 'Apartamento moderno listo para vivir.',
            'foto_portada' => 'propiedades/apartamento.webp',
            'precio' => 250000,
            'Moneda' => 'US$',
            'referencia' => 'MBR-101',
            'zona' => 'Piantini',
            'zona_slug' => 'piantini',
            'zona_publica' => true,
        ]);
        $company = (object) ['titulo' => 'Merkel Bienes Raíces'];

        $seo = app(SeoMetadataService::class)->forProperty($property, $company);

        $this->assertSame(
            'https://www.merkelbienesraices.com.do/propiedades/apartamento-piantini',
            $seo['canonical']
        );
        $this->assertSame('product', $seo['type']);
        $this->assertSame('Product', $seo['schema'][0]['@type']);
        $this->assertSame('USD', $seo['schema'][0]['offers']['priceCurrency']);
        $this->assertSame(
            'https://www.merkelbienesraices.com.do/propiedades/zona/piantini',
            $seo['schema'][1]['itemListElement'][2]['item']
        );
    }

    public function test_staging_is_blocked_and_production_robots_declares_absolute_sitemap(): void
    {
        config([
            'seo.canonical_url' => 'https://www.merkelbienesraices.com.do',
            'seo.indexing_enabled' => true,
        ]);

        $this->get('https://realestate.voipcom.net/robots.txt')
            ->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
            ->assertSee('Disallow: /', false);

        $this->get('https://www.merkelbienesraices.com.do/robots.txt')
            ->assertOk()
            ->assertSee('Allow: /', false)
            ->assertSee('Sitemap: https://www.merkelbienesraices.com.do/sitemap.xml', false);
    }

    public function test_public_header_renders_canonical_social_metadata_schema_and_skip_link(): void
    {
        $seo = [
            'title' => 'Apartamento en Piantini',
            'description' => 'Propiedad de prueba.',
            'canonical' => 'https://www.merkelbienesraices.com.do/propiedades/apartamento-piantini',
            'image' => 'https://www.merkelbienesraices.com.do/assets/propiedad.webp',
            'type' => 'product',
            'robots' => 'index, follow',
            'schema' => [['@context' => 'https://schema.org', '@type' => 'Product', 'name' => 'Apartamento']],
        ];

        $html = view('layout.encabezado-landing', [
            'inmo' => null,
            'frontendTheme' => [],
            'seo' => $seo,
        ])->render();

        $this->assertStringContainsString('<title>Apartamento en Piantini</title>', $html);
        $this->assertStringContainsString('<link rel="canonical" href="' . $seo['canonical'] . '"', $html);
        $this->assertStringContainsString('name="twitter:card" content="summary_large_image"', $html);
        $this->assertStringContainsString('type="application/ld+json"', $html);
        $this->assertStringContainsString('href="#main-content"', $html);
    }
}
