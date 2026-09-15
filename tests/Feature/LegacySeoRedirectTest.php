<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LegacySeoRedirectTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'app.url' => 'http://localhost',
            'seo.canonical_url' => 'https://www.merkelbienesraices.com.do',
        ]);
        DB::purge('sqlite');
        DB::reconnect('sqlite');
        DB::setDefaultConnection('sqlite');

        Schema::create('propiedads', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->unsignedInteger('zona_id')->nullable();
            $table->boolean('activa')->default(false);
            $table->boolean('aprobada')->default(false);
            $table->boolean('vendida')->default(false);
        });
        Schema::create('posts', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->boolean('activo')->default(false);
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
        });
        Schema::create('zonas', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->boolean('is_public')->default(true);
        });
    }

    public function test_public_legacy_urls_redirect_permanently_to_the_new_structure(): void
    {
        DB::table('propiedads')->insert([
            'slug' => 'apartamento-publico', 'zona_id' => 1,
            'activa' => true, 'aprobada' => true, 'vendida' => false,
        ]);
        DB::table('posts')->insert([
            'slug' => 'guia-compra', 'activo' => true, 'status' => 'published', 'published_at' => now()->subDay(),
        ]);
        DB::table('zonas')->insert(['slug' => 'piantini', 'is_public' => true]);

        $this->get('/propiedad/apartamento-publico')
            ->assertStatus(301)
            ->assertRedirect('/propiedades/apartamento-publico');
        $this->get('/post/guia-compra')
            ->assertStatus(301)
            ->assertRedirect('/blog/guia-compra');
        $this->get('/piantini')
            ->assertStatus(301)
            ->assertRedirect('/propiedades/zona/piantini');
    }

    public function test_hidden_legacy_property_returns_not_found_instead_of_redirecting(): void
    {
        DB::table('propiedads')->insert([
            'slug' => 'propiedad-oculta', 'activa' => true, 'aprobada' => false, 'vendida' => false,
        ]);

        $this->get('/propiedad/propiedad-oculta')
            ->assertNotFound()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }
}
