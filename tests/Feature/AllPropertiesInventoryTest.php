<?php

namespace Tests\Feature;

use App\Http\Livewire\MostrarPropiedades;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AllPropertiesInventoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'permission.cache.store' => 'array',
            'session.driver' => 'array',
        ]);

        DB::purge('sqlite');
        DB::reconnect('sqlite');
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        Schema::create('users', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->boolean('activo')->default(true);
            $table->integer('rol')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('roles', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create('permissions', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create('model_has_roles', function (Blueprint $table): void {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->primary(['role_id', 'model_id', 'model_type']);
        });

        Schema::create('propiedads', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('referencia')->nullable();
            $table->string('foto_portada')->nullable();
            $table->unsignedInteger('provincia')->nullable();
            $table->string('ciudad')->nullable();
            $table->unsignedInteger('sector_id')->nullable();
            $table->unsignedInteger('barrio_id')->nullable();
            $table->string('direccion')->nullable();
            $table->double('precio')->nullable();
            $table->string('titulo')->nullable();
            $table->unsignedInteger('habitaciones')->nullable();
            $table->unsignedInteger('banos')->nullable();
            $table->unsignedInteger('parqueos')->nullable();
            $table->double('metraje')->nullable();
            $table->string('asignada_a')->nullable();
            $table->unsignedInteger('captada_por')->nullable();
            $table->unsignedInteger('tipo')->nullable();
            $table->unsignedInteger('disponible_para')->nullable();
            $table->boolean('aprobada')->default(false);
            $table->boolean('activa')->default(true);
            $table->boolean('destacada')->default(false);
            $table->boolean('vendida')->default(false);
            $table->unsignedInteger('clicks')->default(0);
            $table->string('Moneda')->nullable();
            $table->timestamps();
        });

        Schema::create('provincias', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('provincia');
        });

        Schema::create('sectores', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('sector');
        });

        Schema::create('barrios', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('barrio');
        });

        Schema::create('tipos_de_propiedads', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('tipo');
        });

        Schema::create('disponible_paras', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('disponible_para');
        });

        DB::table('provincias')->insert(['id' => 1, 'provincia' => 'Distrito Nacional']);
        DB::table('sectores')->insert(['id' => 1, 'sector' => 'Piantini']);
        DB::table('barrios')->insert(['id' => 1, 'barrio' => 'Ensanche Naco']);
        DB::table('tipos_de_propiedads')->insert(['id' => 1, 'tipo' => 'Apartamento']);
        DB::table('disponible_paras')->insert(['id' => 1, 'disponible_para' => 'En venta']);
    }

    public function test_inventory_shows_properties_from_different_creators_and_supports_search(): void
    {
        $administrator = $this->administrator();
        $otherCreator = User::create(['name' => 'Otro captador', 'email' => 'otro@example.test', 'activo' => true]);
        $firstPropertyId = $this->insertProperty('Apartamento Mirador Sur', $administrator->id, true, true, false);
        $this->insertProperty('Casa en Piantini', $otherCreator->id, false, false, true);

        Livewire::actingAs($administrator)
            ->test(MostrarPropiedades::class)
            ->assertSee('Apartamento Mirador Sur')
            ->assertSee('Casa en Piantini')
            ->assertSee('Aprobada')
            ->assertSee('No publicada')
            ->assertSee('Vendida')
            ->assertSee(route('vercualquierpropiedad', $firstPropertyId), false)
            ->set('criterio', 'Mirador')
            ->assertSee('Apartamento Mirador Sur')
            ->assertDontSee('Casa en Piantini')
            ->call('clearSearch')
            ->assertSet('criterio', '');
    }

    public function test_only_administrators_can_open_the_global_inventory_route(): void
    {
        $administrator = $this->administrator();
        $advisor = User::create(['name' => 'Asesor', 'email' => 'asesor@example.test', 'activo' => true]);
        Role::findOrCreate('asesor', 'web');
        $advisor->assignRole('asesor');

        $this->actingAs($administrator)
            ->get(route('consultarpropiedades'))
            ->assertOk()
            ->assertSee('Todas las propiedades');

        $this->actingAs($advisor)
            ->get(route('consultarpropiedades'))
            ->assertForbidden();
    }

    public function test_inventory_keeps_the_existing_pagination(): void
    {
        $administrator = $this->administrator();

        for ($position = 1; $position <= 21; $position++) {
            $this->insertProperty(
                'Propiedad paginada ' . $position,
                $administrator->id,
                true,
                true,
                false,
                now()->addSeconds($position)
            );
        }

        Livewire::actingAs($administrator)
            ->test(MostrarPropiedades::class)
            ->assertSee('Propiedad paginada 21')
            ->call('gotoPage', 2)
            ->assertSee('Propiedad paginada 1')
            ->assertDontSee('Propiedad paginada 21');
    }

    private function administrator(): User
    {
        $administrator = User::create(['name' => 'Administradora', 'email' => 'admin@example.test', 'activo' => true]);
        Role::findOrCreate('admin', 'web');
        $administrator->assignRole('admin');

        return $administrator;
    }

    private function insertProperty(string $title, int $creatorId, bool $approved, bool $active, bool $sold, $createdAt = null): int
    {
        return DB::table('propiedads')->insertGetId([
            'referencia' => 'PROP-' . $creatorId . '-' . substr($title, 0, 4),
            'foto_portada' => 'assets/prop-apto-1.jpg',
            'provincia' => 1,
            'ciudad' => 'Santo Domingo',
            'sector_id' => 1,
            'barrio_id' => 1,
            'direccion' => 'Avenida de prueba',
            'precio' => 12500000,
            'titulo' => $title,
            'habitaciones' => 2,
            'banos' => 2,
            'parqueos' => 1,
            'metraje' => 85,
            'asignada_a' => 'asesor@example.test',
            'captada_por' => $creatorId,
            'tipo' => 1,
            'disponible_para' => 1,
            'aprobada' => $approved,
            'activa' => $active,
            'vendida' => $sold,
            'Moneda' => 'RD$',
            'created_at' => $createdAt ?: now(),
            'updated_at' => $createdAt ?: now(),
        ]);
    }
}
