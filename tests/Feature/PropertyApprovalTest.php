<?php

namespace Tests\Feature;

use App\Http\Livewire\MostrarPropiedadesPendientesPorAprobar;
use App\Models\Propiedad;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class PropertyApprovalTest extends TestCase
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
            $table->string('titulo')->nullable();
            $table->string('direccion')->nullable();
            $table->double('precio')->nullable();
            $table->string('Moneda')->nullable();
            $table->boolean('aprobada')->default(false);
            $table->boolean('activa')->default(true);
            $table->unsignedInteger('clicks')->default(0);
            $table->unsignedInteger('zona_id')->nullable();
            $table->unsignedInteger('captada_por')->nullable();
            $table->unsignedInteger('asignada_a_id')->nullable();
            $table->string('asignada_a')->nullable();
            $table->timestamps();
        });

        Schema::create('zonas', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('zona');
        });
    }

    public function test_an_administrator_can_approve_and_withdraw_property_approval(): void
    {
        $administrator = $this->administrator();
        $property = $this->propertyFor($administrator);

        $this->withoutMiddleware();
        $this->actingAs($administrator, 'web');
        $this->assertAuthenticatedAs($administrator, 'web');

        $this
            ->patchJson(route('admin.propiedades.aprobacion', $property->getKey()), ['aprobada' => true])
            ->assertOk()
            ->assertJsonPath('aprobada', true)
            ->assertJsonPath('status_label', 'Aprobada');

        $this->assertDatabaseHas('propiedads', ['id' => $property->id, 'aprobada' => 1]);

        $this->actingAs($administrator)
            ->patchJson(route('admin.propiedades.aprobacion', $property->getKey()), ['aprobada' => false])
            ->assertOk()
            ->assertJsonPath('aprobada', false)
            ->assertJsonPath('status_label', 'Pendiente de aprobación');

        $this->assertDatabaseHas('propiedads', ['id' => $property->id, 'aprobada' => 0]);
    }

    public function test_a_non_administrator_cannot_change_property_approval(): void
    {
        $owner = User::create(['name' => 'Asesor', 'email' => 'asesor@example.test', 'activo' => true]);
        $property = $this->propertyFor($owner);

        $this->withoutMiddleware();
        $this->actingAs($owner)
            ->patchJson(route('admin.propiedades.aprobacion', $property->getKey()), ['aprobada' => true])
            ->assertForbidden();

        $this->assertDatabaseHas('propiedads', ['id' => $property->id, 'aprobada' => 0]);
    }

    public function test_the_approval_list_renders_accessible_status_controls(): void
    {
        $administrator = $this->administrator();
        $property = $this->propertyFor($administrator);

        $this->actingAs($administrator);

        Livewire::test(MostrarPropiedadesPendientesPorAprobar::class)
            ->assertSee($property->titulo)
            ->assertSee('Pendiente de aprobación')
            ->assertSee('role="switch"', false)
            ->call('setEstado', 'pendientes')
            ->assertSet('estado', 'pendientes');
    }

    private function administrator(): User
    {
        $administrator = User::create(['name' => 'Administradora', 'email' => 'admin@example.test', 'activo' => true]);
        Role::findOrCreate('admin', 'web');
        $administrator->assignRole('admin');

        return $administrator;
    }

    private function propertyFor(User $user): Propiedad
    {
        return Propiedad::create([
            'referencia' => 'PROP-TEST-0001',
            'titulo' => 'Apartamento de prueba para aprobación',
            'foto_portada' => 'assets/prop-apto-1.jpg',
            'direccion' => 'Santo Domingo',
            'precio' => 12500000,
            'Moneda' => 'RD$',
            'aprobada' => false,
            'captada_por' => $user->id,
            'asignada_a_id' => $user->id,
            'asignada_a' => $user->email,
        ]);
    }
}
