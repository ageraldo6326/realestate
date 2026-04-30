<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

/**
 * Test Suite para módulo de Usuarios.
 * 
 * Cubre:
 * - CRUD completo (create, read, update, delete)
 * - Validaciones de entrada
 * - Seguridad y autenticación
 * - Soft deletes
 * - Protección de superadmin
 * - Integridad de datos
 */
class UsuariosCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $asesorUser;

    /**
     * Setup: crear roles y usuarios de prueba.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Crear roles Spatie si no existen
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'asesor', 'guard_name' => 'web']);

        // Crear usuario admin para pruebas
        $this->adminUser = User::factory()->create([
            'name' => 'Admin Usuario',
            'email' => 'admin@test.com',
            'rol' => 1,
            'activo' => 1,
        ]);
        $this->adminUser->assignRole('admin');

        // Crear usuario asesor
        $this->asesorUser = User::factory()->create([
            'name' => 'Asesor Usuario',
            'email' => 'asesor@test.com',
            'rol' => 0,
            'activo' => 1,
        ]);
        $this->asesorUser->assignRole('asesor');
    }

    // ============================================
    // TESTS DE CREACIÓN (STORE)
    // ============================================

    /**
     * Test: Crear usuario válido correctamente.
     */
    public function test_crear_usuario_valido()
    {
        $this->actingAs($this->adminUser);

        $data = [
            'name' => 'Juan Pérez',
            'email' => 'juan.perez@example.com',
            'telefono' => '+34912345678',
            'descripcion' => 'Agente de ventas experimentado en propiedades residenciales.',
            'metadescription' => 'Juan Pérez - Agente inmobiliario profesional.',
            'titulo' => 'Agente Senior',
            'facebook' => 'https://facebook.com/juanperez',
            'instagram' => 'https://instagram.com/juanperez',
            'whatsapp' => '+34912345678',
            'tiktok' => 'https://tiktok.com/@juanperez',
            'rol' => 0, // Asesor
            'mostrar' => 1,
            'activo' => 1,
            'orden' => 10,
            'requiere_aprobacion_propiedades' => 0,
            'new_password' => 'SecurePass123',
            'new_password_confirmation' => 'SecurePass123',
        ];

        $response = $this->post(route('usuarios.store'), $data);

        $response->assertRedirect(route('usuarios.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('users', [
            'name' => 'Juan Pérez',
            'email' => 'juan.perez@example.com',
            'rol' => 0,
            'activo' => 1,
        ]);

        $usuario = User::where('email', 'juan.perez@example.com')->first();
        $this->assertTrue(Hash::check('SecurePass123', $usuario->password));
        $this->assertTrue($usuario->hasRole('asesor'));
    }

    /**
     * Test: Crear usuario sin autenticación - debe fallar.
     */
    public function test_crear_usuario_sin_autenticacion_falla()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'telefono' => '+34912345678',
            'descripcion' => 'Test description with enough characters.',
            'rol' => 0,
            'mostrar' => 1,
            'activo' => 1,
            'requiere_aprobacion_propiedades' => 0,
            'new_password' => 'SecurePass123',
            'new_password_confirmation' => 'SecurePass123',
        ];

        $response = $this->post(route('usuarios.store'), $data);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }

    /**
     * Test: Crear usuario sin rol admin - debe fallar (403 Forbidden).
     */
    public function test_crear_usuario_sin_rol_admin_falla()
    {
        $this->actingAs($this->asesorUser);

        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'telefono' => '+34912345678',
            'descripcion' => 'Test description with enough characters.',
            'rol' => 0,
            'mostrar' => 1,
            'activo' => 1,
            'requiere_aprobacion_propiedades' => 0,
            'new_password' => 'SecurePass123',
            'new_password_confirmation' => 'SecurePass123',
        ];

        $response = $this->post(route('usuarios.store'), $data);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }

    /**
     * Test: Email duplicado - validación debe rechazar.
     */
    public function test_crear_usuario_con_email_duplicado_falla()
    {
        $this->actingAs($this->adminUser);

        $existing = User::factory()->create(['email' => 'duplicado@test.com']);

        $data = [
            'name' => 'Nuevo Usuario',
            'email' => 'duplicado@test.com',
            'telefono' => '+34912345678',
            'descripcion' => 'Test description with enough characters.',
            'rol' => 0,
            'mostrar' => 1,
            'activo' => 1,
            'requiere_aprobacion_propiedades' => 0,
            'new_password' => 'SecurePass123',
            'new_password_confirmation' => 'SecurePass123',
        ];

        $response = $this->post(route('usuarios.store'), $data);

        $response->assertSessionHasErrors('email');
        $this->assertCount(1, User::where('email', 'duplicado@test.com')->get());
    }

    /**
     * Test: Email duplicado case-insensitive - debe rechazar.
     */
    public function test_crear_usuario_con_email_duplicado_case_insensitive_falla()
    {
        $this->actingAs($this->adminUser);

        User::factory()->create(['email' => 'test@example.com']);

        $data = [
            'name' => 'Nuevo Usuario',
            'email' => 'TEST@EXAMPLE.COM', // Diferente caso
            'telefono' => '+34912345678',
            'descripcion' => 'Test description with enough characters.',
            'rol' => 0,
            'mostrar' => 1,
            'activo' => 1,
            'requiere_aprobacion_propiedades' => 0,
            'new_password' => 'SecurePass123',
            'new_password_confirmation' => 'SecurePass123',
        ];

        $response = $this->post(route('usuarios.store'), $data);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test: Nombre vacío/solo espacios - validación debe rechazar.
     */
    public function test_crear_usuario_con_nombre_vacio_falla()
    {
        $this->actingAs($this->adminUser);

        $data = [
            'name' => '   ', // Solo espacios
            'email' => 'test@example.com',
            'telefono' => '+34912345678',
            'descripcion' => 'Test description with enough characters.',
            'rol' => 0,
            'mostrar' => 1,
            'activo' => 1,
            'requiere_aprobacion_propiedades' => 0,
            'new_password' => 'SecurePass123',
            'new_password_confirmation' => 'SecurePass123',
        ];

        $response = $this->post(route('usuarios.store'), $data);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test: Password débil (sin mayúsculas, minúsculas o dígitos) - debe rechazar.
     */
    public function test_crear_usuario_con_password_debil_falla()
    {
        $this->actingAs($this->adminUser);

        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'telefono' => '+34912345678',
            'descripcion' => 'Test description with enough characters.',
            'rol' => 0,
            'mostrar' => 1,
            'activo' => 1,
            'requiere_aprobacion_propiedades' => 0,
            'new_password' => 'onlysmall', // Sin mayúsculas, sin dígitos
            'new_password_confirmation' => 'onlysmall',
        ];

        $response = $this->post(route('usuarios.store'), $data);

        $response->assertSessionHasErrors('new_password');
    }

    /**
     * Test: Confirmación de password no coincide - debe rechazar.
     */
    public function test_crear_usuario_con_password_confirmation_no_coincide_falla()
    {
        $this->actingAs($this->adminUser);

        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'telefono' => '+34912345678',
            'descripcion' => 'Test description with enough characters.',
            'rol' => 0,
            'mostrar' => 1,
            'activo' => 1,
            'requiere_aprobacion_propiedades' => 0,
            'new_password' => 'SecurePass123',
            'new_password_confirmation' => 'DifferentPass456', // No coincide
        ];

        $response = $this->post(route('usuarios.store'), $data);

        $response->assertSessionHasErrors('new_password');
    }

    /**
     * Test: Descripción muy corta - validación debe rechazar.
     */
    public function test_crear_usuario_con_descripcion_corta_falla()
    {
        $this->actingAs($this->adminUser);

        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'telefono' => '+34912345678',
            'descripcion' => 'Short', // Menos de 10 caracteres
            'rol' => 0,
            'mostrar' => 1,
            'activo' => 1,
            'requiere_aprobacion_propiedades' => 0,
            'new_password' => 'SecurePass123',
            'new_password_confirmation' => 'SecurePass123',
        ];

        $response = $this->post(route('usuarios.store'), $data);

        $response->assertSessionHasErrors('descripcion');
    }

    // ============================================
    // TESTS DE ACTUALIZACIÓN (UPDATE)
    // ============================================

    /**
     * Test: Actualizar usuario válido.
     */
    public function test_actualizar_usuario_valido()
    {
        $usuario = User::factory()->create(['rol' => 0]);
        $this->actingAs($this->adminUser);

        $data = [
            'telefono' => '+34987654321',
            'descripcion' => 'Updated description with enough characters to pass validation.',
            'metadescription' => 'Updated meta',
            'titulo' => 'Updated Title',
            'facebook' => 'https://facebook.com/updated',
            'instagram' => 'https://instagram.com/updated',
            'whatsapp' => '+34987654321',
            'tiktok' => 'https://tiktok.com/@updated',
            'rol' => 1, // Cambiar a admin
            'mostrar' => 0, // Cambiar a no mostrar
            'estado' => 1,
            'orden' => 5,
            'modo_aprobacion_propiedades' => 'required',
        ];

        $response = $this->put(route('usuarios.update', $usuario->id), $data);

        $response->assertRedirect(route('usuarios.index'));

        $usuario->refresh();
        $this->assertEquals('+34987654321', $usuario->telefono);
        $this->assertEquals(1, $usuario->rol);
        $this->assertEquals(0, $usuario->mostrar);
        $this->assertEquals(1, $usuario->requiere_aprobacion_propiedades);
        $this->assertTrue($usuario->hasRole('admin'));
    }

    /**
     * Test: Actualizar contraseña de usuario.
     */
    public function test_actualizar_password_usuario()
    {
        $usuario = User::factory()->create();
        $this->actingAs($this->adminUser);

        $data = [
            'telefono' => $usuario->telefono,
            'descripcion' => 'Current description with enough characters.',
            'rol' => $usuario->rol,
            'mostrar' => $usuario->mostrar,
            'estado' => $usuario->activo,
            'new_password' => 'NewSecurePass789',
            'new_password_confirmation' => 'NewSecurePass789',
        ];

        $response = $this->put(route('usuarios.update', $usuario->id), $data);

        $response->assertRedirect(route('usuarios.index'));

        $usuario->refresh();
        $this->assertTrue(Hash::check('NewSecurePass789', $usuario->password));
    }

    /**
     * Test: Actualizar usuario no encontrado - debe fallar.
     */
    public function test_actualizar_usuario_no_encontrado_falla()
    {
        $this->actingAs($this->adminUser);

        $response = $this->put(route('usuarios.update', 9999), [
            'telefono' => '+34912345678',
            'descripcion' => 'Test description with enough characters.',
            'rol' => 0,
            'mostrar' => 1,
            'estado' => 1,
        ]);

        $response->assertRedirect(route('usuarios.index'));
        $response->assertSessionHas('error');
    }

    /**
     * Test: Protección de superadmin - no se puede desactivar.
     */
    public function test_superadmin_protegido_no_puede_desactivarse()
    {
        $this->actingAs($this->adminUser);

        // Simular superadmin protegido
        config(['security.superadmin_email' => 'superadmin@example.com']);
        config(['security.allow_superadmin_mutations' => false]);

        $superadmin = User::factory()->create([
            'email' => 'superadmin@example.com',
            'activo' => 1,
        ]);
        $superadmin->assignRole('admin');

        $data = [
            'telefono' => '+34912345678',
            'descripcion' => 'Superadmin user with enough characters.',
            'rol' => 1,
            'mostrar' => 1,
            'estado' => 0, // Intentar desactivar
        ];

        $response = $this->put(route('usuarios.update', $superadmin->id), $data);

        $superadmin->refresh();
        $this->assertEquals(1, $superadmin->activo); // Sigue activo
    }

    // ============================================
    // TESTS DE ELIMINACIÓN (DESTROY)
    // ============================================

    /**
     * Test: Eliminar usuario válido (soft delete).
     */
    public function test_eliminar_usuario_valido()
    {
        $usuario = User::factory()->create();
        $this->actingAs($this->adminUser);

        $response = $this->delete(route('usuarios.destroy', $usuario->id));

        $response->assertRedirect();
        $response->assertSessionHas('status');

        // Verificar soft delete
        $this->assertSoftDeleted('users', ['id' => $usuario->id]);
    }

    /**
     * Test: No se puede eliminar el usuario autenticado.
     */
    public function test_eliminar_usuario_autenticado_falla()
    {
        $this->actingAs($this->adminUser);

        $response = $this->delete(route('usuarios.destroy', $this->adminUser->id));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'No puedes eliminar tu propio usuario.');

        // Usuario aún debe existir
        $this->assertDatabaseHas('users', ['id' => $this->adminUser->id]);
    }

    /**
     * Test: No se puede eliminar superadmin protegido.
     */
    public function test_eliminar_superadmin_protegido_falla()
    {
        config(['security.superadmin_email' => 'superadmin@example.com']);
        config(['security.allow_superadmin_mutations' => false]);

        $superadmin = User::factory()->create(['email' => 'superadmin@example.com']);
        $superadmin->assignRole('admin');

        $this->actingAs($this->adminUser);

        $response = $this->delete(route('usuarios.destroy', $superadmin->id));

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $this->assertNotSoftDeleted('users', ['id' => $superadmin->id]);
    }

    /**
     * Test: Eliminar usuario no encontrado.
     */
    public function test_eliminar_usuario_no_encontrado_falla()
    {
        $this->actingAs($this->adminUser);

        $response = $this->delete(route('usuarios.destroy', 9999));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Usuario no encontrado.');
    }

    /**
     * Test: Restaurar usuario eliminado.
     */
    public function test_restaurar_usuario_eliminado()
    {
        $usuario = User::factory()->create();
        $usuario->delete(); // Soft delete

        $this->actingAs($this->adminUser);

        // Restauración directa via modelo (en Livewire)
        $usuario->restore();

        $this->assertNotSoftDeleted('users', ['id' => $usuario->id]);
    }

    // ============================================
    // TESTS DE AUTORIZACIÓN
    // ============================================

    /**
     * Test: Solo admin puede ver listado de usuarios.
     */
    public function test_solo_admin_puede_ver_usuarios()
    {
        $this->actingAs($this->asesorUser);

        $response = $this->get(route('usuarios.index'));

        $response->assertStatus(403);
    }

    /**
     * Test: Admin puede ver listado de usuarios.
     */
    public function test_admin_puede_ver_usuarios()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('usuarios.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.usuarios.index');
    }

    /**
     * Test: Listado muestra paginación correcta.
     */
    public function test_listado_usuarios_paginado()
    {
        User::factory()->count(60)->create();

        $this->actingAs($this->adminUser);

        $response = $this->get(route('usuarios.index'));

        $response->assertViewHas('usuarios');
        $usuarios = $response->viewData('usuarios');
        $this->assertEquals(50, $usuarios->count()); // Paginación de 50
        $this->assertTrue($usuarios->hasPages());
    }

    // ============================================
    // TESTS DE INTEGRIDAD DE DATOS
    // ============================================

    /**
     * Test: Email siempre se guarda en minúsculas.
     */
    public function test_email_se_guarda_en_minusculas()
    {
        $this->actingAs($this->adminUser);

        $data = [
            'name' => 'Test User',
            'email' => 'TEST@EXAMPLE.COM',
            'telefono' => '+34912345678',
            'descripcion' => 'Test description with enough characters.',
            'metadescription' => null,
            'titulo' => null,
            'facebook' => null,
            'instagram' => null,
            'whatsapp' => null,
            'tiktok' => null,
            'rol' => 0,
            'mostrar' => 1,
            'activo' => 1,
            'orden' => null,
            'requiere_aprobacion_propiedades' => 0,
            'new_password' => 'SecurePass123',
            'new_password_confirmation' => 'SecurePass123',
        ];

        $response = $this->post(route('usuarios.store'), $data);
        
        if ($response->status() !== 302) {
            dd($response->getContent());
        }

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    /**
     * Test: Campos de rol y mostrar son booleanos/int correctos.
     */
    public function test_campos_booleanos_se_guardan_correctamente()
    {
        $this->actingAs($this->adminUser);

        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'telefono' => '+34912345678',
            'descripcion' => 'Test description with enough characters.',
            'rol' => 1,
            'mostrar' => 0,
            'activo' => 1,
            'requiere_aprobacion_propiedades' => 1,
            'new_password' => 'SecurePass123',
            'new_password_confirmation' => 'SecurePass123',
        ];

        $this->post(route('usuarios.store'), $data);

        $usuario = User::where('email', 'test@example.com')->first();
        $this->assertSame(1, $usuario->rol);
        $this->assertSame(0, $usuario->mostrar);
        $this->assertSame(true, (bool) $usuario->activo);
        $this->assertSame(true, (bool) $usuario->requiere_aprobacion_propiedades);
    }

    /**
     * Test: Espacios en blanco se normalizan/trimean.
     */
    public function test_espacios_blancos_se_normalizan()
    {
        $this->actingAs($this->adminUser);

        $data = [
            'name' => '  Test User  ',
            'email' => '  test@example.com  ',
            'telefono' => '  +34912345678  ',
            'descripcion' => '  Test description with enough characters.  ',
            'titulo' => '  Senior Agent  ',
            'rol' => 0,
            'mostrar' => 1,
            'activo' => 1,
            'requiere_aprobacion_propiedades' => 0,
            'new_password' => 'SecurePass123',
            'new_password_confirmation' => 'SecurePass123',
        ];

        $this->post(route('usuarios.store'), $data);

        $usuario = User::where('email', 'test@example.com')->first();
        $this->assertEquals('Test User', $usuario->name);
        $this->assertEquals('+34912345678', $usuario->telefono);
        $this->assertEquals('Senior Agent', $usuario->titulo);
    }
}
