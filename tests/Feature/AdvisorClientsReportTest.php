<?php

namespace Tests\Feature;

use App\Http\Livewire\ClientesAsesorConsulta;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AdvisorClientsReportTest extends TestCase
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

        Schema::create('clientes', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->double('precio_mini')->nullable();
            $table->double('precio_max')->nullable();
            $table->date('contact_at')->nullable();
            $table->unsignedInteger('captado_por')->nullable();
            $table->unsignedInteger('asignado_a')->nullable();
            $table->timestamps();
        });
    }

    public function test_administrator_can_filter_advisor_client_summary_and_open_detail(): void
    {
        $administrator = $this->administrator();
        $advisor = User::create(['name' => 'Laura Pérez', 'email' => 'laura@example.test', 'activo' => true]);
        $otherAdvisor = User::create(['name' => 'Marco Díaz', 'email' => 'marco@example.test', 'activo' => true]);
        $this->insertClient('Cliente de Laura', $advisor->id, '2026-09-10 00:00:00');
        $this->insertClient('Cliente de Marco', $otherAdvisor->id, '2026-09-11 00:00:00');

        Livewire::actingAs($administrator)
            ->test(ClientesAsesorConsulta::class)
            ->assertSee('Selecciona un período')
            ->set('fecha_ini', '2026-09-01')
            ->set('fecha_fin', '2026-09-30')
            ->call('applyFilters')
            ->assertSee('Laura Pérez')
            ->assertSee('Marco Díaz')
            ->assertSee('Clientes captados')
            ->assertSee(route('verclientesporasesor', ['asesorid' => $advisor->id, 'fecha_ini' => '2026-09-01', 'fecha_fin' => '2026-09-30']), false);

        $this->actingAs($administrator)
            ->get(route('verclientesporasesor', ['asesorid' => $advisor->id, 'fecha_ini' => '2026-09-01', 'fecha_fin' => '2026-09-30']))
            ->assertOk()
            ->assertSee('Cliente de Laura')
            ->assertSee('Ver ficha');
    }

    public function test_invalid_range_is_explained_and_advisors_cannot_open_the_report(): void
    {
        $administrator = $this->administrator();
        $advisor = User::create(['name' => 'Asesor', 'email' => 'asesor@example.test', 'activo' => true]);
        Role::findOrCreate('asesor', 'web');
        $advisor->assignRole('asesor');

        Livewire::actingAs($administrator)
            ->test(ClientesAsesorConsulta::class)
            ->set('fecha_ini', '2026-09-30')
            ->set('fecha_fin', '2026-09-01')
            ->call('applyFilters')
            ->assertSee('La fecha de fin debe ser igual o posterior a la fecha de inicio.');

        $this->actingAs($advisor)
            ->get(route('consultaClientesAsesor'))
            ->assertForbidden();
    }

    private function administrator(): User
    {
        $administrator = User::create(['name' => 'Administradora', 'email' => 'admin@example.test', 'activo' => true]);
        Role::findOrCreate('admin', 'web');
        $administrator->assignRole('admin');

        return $administrator;
    }

    private function insertClient(string $name, int $advisorId, string $createdAt): void
    {
        DB::table('clientes')->insert([
            'nombre' => $name,
            'telefono' => '8095551234',
            'email' => strtolower(str_replace(' ', '.', $name)) . '@example.test',
            'precio_mini' => 1000000,
            'precio_max' => 2000000,
            'contact_at' => '2026-09-10',
            'captado_por' => $advisorId,
            'asignado_a' => $advisorId,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);
    }
}
