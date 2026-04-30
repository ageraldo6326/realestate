<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\BuscarUsuario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BuscarUsuarioCrudTest extends TestCase
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

    public function test_store_creates_valid_user(): void
    {
        $this->actingAs($this->createAdminUser());

        Livewire::test(BuscarUsuario::class)
            ->set('name', 'Maria Perez')
            ->set('email', 'maria.perez@example.com')
            ->set('telefono', '8095551212')
            ->set('descripcion', 'Asesora comercial con experiencia comprobada en ventas premium.')
            ->set('new_password', 'Segura123')
            ->set('new_password_confirmation', 'Segura123')
            ->set('rol', '1')
            ->set('mostrar', '1')
            ->set('activo', '1')
            ->set('orden', '50')
            ->call('store')
            ->assertHasNoErrors();

        $usuario = User::query()->where('email', 'maria.perez@example.com')->first();

        $this->assertNotNull($usuario);
        $this->assertTrue(Hash::check('Segura123', (string) $usuario->password));
        $this->assertSame(1, (int) $usuario->rol);
        $this->assertTrue($usuario->hasRole('admin'));
    }

    public function test_store_fails_with_missing_required_fields(): void
    {
        $this->actingAs($this->createAdminUser());

        Livewire::test(BuscarUsuario::class)
            ->set('name', '   ')
            ->set('email', '')
            ->set('telefono', '')
            ->set('descripcion', '')
            ->set('new_password', '')
            ->set('new_password_confirmation', '')
            ->call('store')
            ->assertHasErrors(['name', 'email', 'telefono', 'descripcion', 'new_password']);
    }

    public function test_store_fails_on_duplicate_email(): void
    {
        $this->actingAs($this->createAdminUser());

        User::factory()->createOne([
            'email' => 'duplicado@example.com',
            'rol' => 0,
        ]);

        Livewire::test(BuscarUsuario::class)
            ->set('name', 'Usuario Nuevo')
            ->set('email', 'duplicado@example.com')
            ->set('telefono', '8091111111')
            ->set('descripcion', 'Perfil comercial para prueba de email duplicado.')
            ->set('new_password', 'Segura123')
            ->set('new_password_confirmation', 'Segura123')
            ->set('rol', '0')
            ->set('mostrar', '1')
            ->set('activo', '1')
            ->call('store')
            ->assertHasErrors(['email']);
    }

    public function test_store_fails_on_weak_password(): void
    {
        $this->actingAs($this->createAdminUser());

        Livewire::test(BuscarUsuario::class)
            ->set('name', 'Clave Debil')
            ->set('email', 'clave.debil@example.com')
            ->set('telefono', '8092222222')
            ->set('descripcion', 'Prueba de validacion de complejidad de clave en usuarios.')
            ->set('new_password', 'password')
            ->set('new_password_confirmation', 'password')
            ->set('rol', '0')
            ->set('mostrar', '1')
            ->set('activo', '1')
            ->call('store')
            ->assertHasErrors(['new_password']);
    }

    public function test_update_updates_user_and_password(): void
    {
        $this->actingAs($this->createAdminUser());

        /** @var User $usuario */
        $usuario = User::factory()->createOne([
            'name' => 'Usuario Base',
            'email' => 'usuario.base@example.com',
            'telefono' => '8093333333',
            'descripcion' => 'Descripcion inicial del usuario para editar.',
            'password' => Hash::make('Inicial123'),
            'rol' => 0,
        ]);

        $this->createRole('asesor');
        $usuario->assignRole('asesor');

        Livewire::test(BuscarUsuario::class)
            ->call('edit', $usuario->id)
            ->set('name', 'Usuario Actualizado')
            ->set('email', 'usuario.actualizado@example.com')
            ->set('telefono', '8094444444')
            ->set('descripcion', 'Descripcion editada con informacion valida y extensa.')
            ->set('rol', '1')
            ->set('mostrar', '1')
            ->set('activo', '1')
            ->set('orden', '30')
            ->set('new_password', 'NuevaClave123')
            ->set('new_password_confirmation', 'NuevaClave123')
            ->call('update', $usuario->id)
            ->assertHasNoErrors();

        $usuario->refresh();

        $this->assertSame('Usuario Actualizado', $usuario->name);
        $this->assertSame('usuario.actualizado@example.com', $usuario->email);
        $this->assertSame('8094444444', $usuario->telefono);
        $this->assertSame(1, (int) $usuario->rol);
        $this->assertTrue(Hash::check('NuevaClave123', (string) $usuario->password));
        $this->assertTrue($usuario->hasRole('admin'));
    }

    public function test_delete_soft_deletes_user(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        /** @var User $usuario */
        $usuario = User::factory()->createOne([
            'email' => 'eliminar@example.com',
            'rol' => 0,
            'activo' => 1,
        ]);

        Livewire::test(BuscarUsuario::class)
            ->call('borrarUsuario', $usuario->id)
            ->assertHasNoErrors();

        $this->assertSoftDeleted('users', ['id' => $usuario->id]);
    }

    public function test_admin_users_route_requires_admin_role(): void
    {
        $responseGuest = $this->get('/admin/usuarios');
        $responseGuest->assertRedirect('/admin/login');

        $this->createRole('asesor');

        /** @var User $asesor */
        $asesor = User::factory()->createOne([
            'rol' => 0,
        ]);
        $asesor->assignRole('asesor');

        $this->actingAs($asesor)
            ->get('/admin/usuarios')
            ->assertForbidden();
    }
}
