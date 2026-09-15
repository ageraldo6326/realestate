<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SeoMigrationsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');
        DB::reconnect('sqlite');
        DB::setDefaultConnection('sqlite');

        Schema::create('zonas', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('zona');
            $table->timestamps();
        });
        Schema::create('posts', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('titulo');
            $table->text('contenido');
            $table->string('foto')->nullable();
            $table->string('metadescription', 160)->nullable();
            $table->boolean('activo')->default(false);
            $table->timestamps();
        });
    }

    public function test_seo_migrations_preserve_records_and_backfill_publication_data(): void
    {
        $zoneId = DB::table('zonas')->insertGetId([
            'zona' => 'Santo Domingo Este', 'created_at' => now(), 'updated_at' => now(),
        ]);
        $postId = DB::table('posts')->insertGetId([
            'titulo' => 'Guía', 'contenido' => 'Contenido editorial de prueba',
            'metadescription' => 'Descripción', 'activo' => true,
            'created_at' => now()->subDay(), 'updated_at' => now(),
        ]);

        $zoneMigration = require database_path('migrations/2026_09_14_000100_add_seo_fields_to_zonas_table.php');
        $postMigration = require database_path('migrations/2026_09_14_000200_add_editorial_seo_fields_to_posts_table.php');
        $zoneMigration->up();
        $postMigration->up();

        $this->assertDatabaseHas('zonas', [
            'id' => $zoneId, 'slug' => 'santo-domingo-este', 'is_public' => true,
        ]);
        $this->assertDatabaseHas('posts', [
            'id' => $postId, 'status' => 'published',
        ]);
        $this->assertNotNull(DB::table('posts')->where('id', $postId)->value('published_at'));
    }
}
