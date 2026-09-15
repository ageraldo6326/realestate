<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SitemapEndpointTest extends TestCase
{
    public function test_sitemap_is_not_a_static_public_asset(): void
    {
        $this->assertFileDoesNotExist(public_path('sitemap.xml'));
        $this->assertStringContainsString(
            'RewriteRule ^(?:sitemap\\.xml|robots\\.txt)$ index.php [L]',
            (string) file_get_contents(public_path('.htaccess'))
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'seo.canonical_url' => 'https://www.merkelbienesraices.com.do',
            'seo.indexing_enabled' => true,
        ]);

        DB::purge('sqlite');
        DB::reconnect('sqlite');
        DB::setDefaultConnection('sqlite');
        $this->createSitemapTables();
        Cache::flush();
    }

    public function test_sitemap_only_contains_canonical_public_content(): void
    {
        DB::table('inmobiliarias')->insert([
            'nombre' => 'Merkel Bienes Raíces',
            'dominio' => 'https://realestate.voipcom.net',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $zoneId = DB::table('zonas')->insertGetId([
            'zona' => 'Piantini',
            'slug' => 'piantini',
            'is_public' => true,
            'seo_description' => 'Guía de la zona.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $typeId = DB::table('tipos_de_propiedads')->insertGetId([
            'tipo' => 'Apartamento',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->insertProperty('apartamento-publico', $zoneId, $typeId, true, true, false);
        $this->insertProperty('apartamento-pendiente', $zoneId, $typeId, true, false, false);
        $this->insertProperty('apartamento-vendido', $zoneId, $typeId, true, true, true);

        DB::table('posts')->insert([
            [
                'slug' => 'guia-publicada', 'activo' => true, 'status' => 'published',
                'published_at' => now()->subDay(), 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'slug' => 'borrador', 'activo' => false, 'status' => 'draft',
                'published_at' => null, 'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        $response = $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $xml = $response->getContent();

        $this->assertStringContainsString('https://www.merkelbienesraices.com.do/propiedades/apartamento-publico', $xml);
        $this->assertStringContainsString('https://www.merkelbienesraices.com.do/propiedades/zona/piantini', $xml);
        $this->assertStringContainsString('https://www.merkelbienesraices.com.do/blog/guia-publicada', $xml);
        $this->assertStringNotContainsString('realestate.voipcom.net', $xml);
        $this->assertStringNotContainsString('/propiedad/', $xml);
        $this->assertStringNotContainsString('apartamento-pendiente', $xml);
        $this->assertStringNotContainsString('apartamento-vendido', $xml);
        $this->assertStringNotContainsString('/post/', $xml);
        $this->assertStringNotContainsString('borrador', $xml);
    }

    private function insertProperty(
        string $slug,
        int $zoneId,
        int $typeId,
        bool $active,
        bool $approved,
        bool $sold
    ): void {
        DB::table('propiedads')->insert([
            'slug' => $slug,
            'zona_id' => $zoneId,
            'tipo' => $typeId,
            'activa' => $active,
            'aprobada' => $approved,
            'vendida' => $sold,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createSitemapTables(): void
    {
        Schema::create('inmobiliarias', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('dominio')->nullable();
            $table->timestamps();
        });

        Schema::create('zonas', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('zona');
            $table->string('slug')->nullable();
            $table->boolean('is_public')->default(true);
            $table->text('seo_description')->nullable();
            $table->timestamps();
        });

        Schema::create('tipos_de_propiedads', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('tipo');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('propiedads', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->unsignedInteger('zona_id')->nullable();
            $table->unsignedInteger('tipo')->nullable();
            $table->boolean('activa')->default(false);
            $table->boolean('aprobada')->default(false);
            $table->boolean('vendida')->default(false);
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->boolean('activo')->default(false);
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }
}
