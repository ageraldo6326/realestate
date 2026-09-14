<?php

namespace Tests\Feature;

use App\Models\Inmobiliaria;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SitemapEndpointTest extends TestCase
{
    public function test_sitemap_endpoint_renders_when_public_directory_is_not_writable(): void
    {
        $this->useInMemorySqliteDatabase();
        $this->createSitemapTables();

        Inmobiliaria::query()->create([
            'nombre' => 'Inmobiliaria de prueba',
            'dominio' => 'https://inmobiliaria.example.test',
        ]);

        Cache::forget('inmobiliaria.config');
        Cache::forget('seo.sitemap.xml');

        $originalPublicPath = $this->app->make('path.public');
        $invalidPublicPath = tempnam(sys_get_temp_dir(), 'sitemap-public-');

        try {
            $this->assertNotFalse($invalidPublicPath);
            $this->app->instance('path.public', $invalidPublicPath);

            $this->get('/sitemap.xml')
                ->assertOk()
                ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
                ->assertSee('https://inmobiliaria.example.test/', false);
        } finally {
            $this->app->instance('path.public', $originalPublicPath);

            if (is_string($invalidPublicPath) && is_file($invalidPublicPath)) {
                unlink($invalidPublicPath);
            }
        }
    }

    private function useInMemorySqliteDatabase(): void
    {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);

        DB::purge('sqlite');
        DB::reconnect('sqlite');
        DB::setDefaultConnection('sqlite');
    }

    private function createSitemapTables(): void
    {
        Schema::create('inmobiliarias', function ($table): void {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('dominio')->nullable();
            $table->timestamps();
        });

        Schema::create('propiedads', function ($table): void {
            $table->increments('id');
            $table->boolean('activa')->default(false);
            $table->string('slug')->nullable();
            $table->timestamps();
        });

        Schema::create('zonas', function ($table): void {
            $table->increments('id');
            $table->string('zona')->nullable();
            $table->timestamps();
        });

        Schema::create('tipos_de_propiedads', function ($table): void {
            $table->increments('id');
            $table->string('tipo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('posts', function ($table): void {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }
}
