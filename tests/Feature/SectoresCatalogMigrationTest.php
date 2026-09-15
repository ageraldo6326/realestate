<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SectoresCatalogMigrationTest extends TestCase
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

        Schema::create('provincias', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('provincia', 30)->nullable();
            $table->timestamps();
        });

        Schema::create('sectores', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('provincia_id');
            $table->string('sector');
            $table->timestamps();
            $table->unique(['provincia_id', 'sector']);
            $table->foreign('provincia_id')->references('id')->on('provincias')->cascadeOnDelete();
        });
    }

    public function test_catalog_uses_real_province_ids_and_is_idempotent(): void
    {
        DB::table('provincias')->insert([
            [
                'id' => 101,
                'provincia' => 'AZUA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 205,
                'provincia' => 'DISTRITO NACIONAL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 307,
                'provincia' => 'EL SEYBO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        require_once database_path('migrations/2026_04_29_200000_seed_full_sectores_catalog_from_datos_rep_dom.php');
        $migration = new \SeedFullSectoresCatalogFromDatosRepDom();

        $migration->up();
        $sectorCount = DB::table('sectores')->count();
        $migration->up();

        $this->assertDatabaseHas('sectores', [
            'provincia_id' => 101,
            'sector' => 'Amiama Gómez',
        ]);
        $this->assertDatabaseHas('sectores', [
            'provincia_id' => 205,
            'sector' => 'Santo Domingo de Guzmán',
        ]);
        $this->assertDatabaseHas('sectores', [
            'provincia_id' => 307,
            'sector' => 'Santa Cruz de El Seibo',
        ]);
        $this->assertSame(32, DB::table('provincias')->count());
        $this->assertSame($sectorCount, DB::table('sectores')->count());
        $this->assertFalse(DB::table('sectores')->whereIn('provincia_id', [1, 3, 4])->exists());
    }
}
