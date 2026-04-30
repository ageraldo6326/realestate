<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\BuscarZona;
use App\Models\Propiedad;
use App\Models\User;
use App\Models\Zonas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BuscarZonaCrudTest extends TestCase
{
    use RefreshDatabase;

    private function createRole(string $name): Role
    {
        return Role::firstOrCreate([
            'name' => $name,
            'guard_name' => 'web',
        ]);
    }

    private function createAdminUser(): User
    {
        $this->createRole('admin');

        /** @var User $user */
        $user = User::factory()->createOne([
            'rol' => 1,
            'mostrar' => 1,
            'activo' => 1,
        ]);

        $user->assignRole('admin');

        return $user;
    }

    public function test_store_creates_valid_zone_and_trims_spaces(): void
    {
        $this->actingAs($this->createAdminUser());

        Livewire::test(BuscarZona::class)
            ->set('zona', '  Naco   Centro  ')
            ->call('store')
            ->assertHasNoErrors();

        $zona = Zonas::query()->first();

        $this->assertNotNull($zona);
        $this->assertSame('Naco Centro', $zona->zona);
    }

    public function test_store_rejects_blank_or_short_zone(): void
    {
        $this->actingAs($this->createAdminUser());

        Livewire::test(BuscarZona::class)
            ->set('zona', ' ')
            ->call('store')
            ->assertHasErrors(['zona']);

        Livewire::test(BuscarZona::class)
            ->set('zona', 'A')
            ->call('store')
            ->assertHasErrors(['zona']);
    }

    public function test_store_rejects_duplicate_zone_name(): void
    {
        $this->actingAs($this->createAdminUser());

        Zonas::query()->create(['zona' => 'Piantini']);

        Livewire::test(BuscarZona::class)
            ->set('zona', 'Piantini')
            ->call('store')
            ->assertHasErrors(['zona']);
    }

    public function test_update_rejects_duplicate_name_of_another_zone(): void
    {
        $this->actingAs($this->createAdminUser());

        $zonaA = Zonas::query()->create(['zona' => 'Evaristo Morales']);
        $zonaB = Zonas::query()->create(['zona' => 'Gazcue']);

        Livewire::test(BuscarZona::class)
            ->call('edit', $zonaA->id)
            ->set('zona', $zonaB->zona)
            ->call('update', $zonaA->id)
            ->assertHasErrors(['zona']);
    }

    public function test_delete_is_blocked_when_zone_has_related_properties(): void
    {
        $this->actingAs($this->createAdminUser());

        $zona = Zonas::query()->create(['zona' => 'Los Cacicazgos']);

        Propiedad::query()->create([
            'zona_id' => $zona->id,
        ]);

        Livewire::test(BuscarZona::class)
            ->call('borrarZona', $zona->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('zonas', [
            'id' => $zona->id,
        ]);
    }

    public function test_admin_zones_route_requires_admin_role(): void
    {
        $responseGuest = $this->get('/admin/zonas');
        $responseGuest->assertRedirect('/admin/login');

        $this->createRole('asesor');

        /** @var User $asesor */
        $asesor = User::factory()->createOne([
            'rol' => 0,
        ]);
        $asesor->assignRole('asesor');

        $this->actingAs($asesor)
            ->get('/admin/zonas')
            ->assertForbidden();
    }
}
