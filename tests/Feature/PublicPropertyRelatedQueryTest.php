<?php

namespace Tests\Feature;

use App\Http\Controllers\Frontend\Productdetails;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PublicPropertyRelatedQueryTest extends TestCase
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
            $table->string('slug')->nullable();
        });
        Schema::create('estados', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('estado');
        });
        Schema::create('propiedads', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->unsignedInteger('zona_id')->nullable();
            $table->unsignedInteger('estado_id')->nullable();
            $table->string('foto_portada')->nullable();
            $table->string('titulo');
            $table->unsignedInteger('habitaciones')->nullable();
            $table->unsignedInteger('banos')->nullable();
            $table->string('Moneda')->nullable();
            $table->decimal('precio', 14, 2)->nullable();
            $table->decimal('metraje', 10, 2)->nullable();
            $table->boolean('activa')->default(false);
            $table->boolean('aprobada')->default(false);
            $table->boolean('vendida')->default(false);
            $table->timestamps();
        });
    }

    public function test_related_query_qualifies_property_slug_when_zone_also_has_slug(): void
    {
        DB::table('zonas')->insert(['id' => 10, 'zona' => 'San Isidro', 'slug' => 'san-isidro']);
        DB::table('estados')->insert(['id' => 1, 'estado' => 'Disponible']);
        DB::table('propiedads')->insert([
            $this->propertyData(9, 'apartamento-principal'),
            $this->propertyData(12, 'apartamento-relacionado'),
        ]);

        $controller = new class extends Productdetails
        {
            public function getRelatedProperties(int $propertyId, ?int $zoneId): Collection
            {
                return $this->relatedProperties($propertyId, $zoneId);
            }
        };

        $related = $controller->getRelatedProperties(9, 10);

        $this->assertCount(1, $related);
        $this->assertSame('apartamento-relacionado', $related->first()->slug);
        $this->assertSame('San Isidro', $related->first()->zona);
    }

    private function propertyData(int $id, string $slug): array
    {
        return [
            'id' => $id,
            'slug' => $slug,
            'zona_id' => 10,
            'estado_id' => 1,
            'titulo' => 'Apartamento en San Isidro',
            'activa' => true,
            'aprobada' => true,
            'vendida' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
