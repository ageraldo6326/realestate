<?php

namespace Tests\Feature;

use App\Http\Middleware\PermissionOrSuperadminMiddleware;
use App\Http\Middleware\RoleOrPermissionOrSuperadminMiddleware;
use App\Http\Middleware\RoleOrSuperadminMiddleware;
use App\Http\Requests\Admin\StoreEmpresaRequest;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Tests\TestCase;

class SuperadminAuthorizationTest extends TestCase
{
    public function test_kernel_usa_los_tres_middlewares_con_bypass_global(): void
    {
        $aliases = $this->app['router']->getMiddleware();

        $this->assertSame(RoleOrSuperadminMiddleware::class, $aliases['role']);
        $this->assertSame(PermissionOrSuperadminMiddleware::class, $aliases['permission']);
        $this->assertSame(RoleOrPermissionOrSuperadminMiddleware::class, $aliases['role_or_permission']);
    }

    public function test_superadmin_supera_middleware_de_rol(): void
    {
        $user = $this->mockUser(true);

        $response = (new RoleOrSuperadminMiddleware())->handle(
            Request::create('/admin', 'GET'),
            $this->successfulNext(),
            'admin'
        );

        $this->assertSame('OK', $response);
        $user->shouldNotHaveReceived('hasAnyRole');
    }

    public function test_superadmin_supera_middleware_de_permiso_y_de_rol_o_permiso(): void
    {
        $this->mockUser(true);

        $permissionResponse = (new PermissionOrSuperadminMiddleware())->handle(
            Request::create('/admin', 'GET'),
            $this->successfulNext(),
            'configurar-empresa'
        );

        $roleOrPermissionResponse = (new RoleOrPermissionOrSuperadminMiddleware())->handle(
            Request::create('/admin', 'GET'),
            $this->successfulNext(),
            'admin|configurar-empresa'
        );

        $this->assertSame('OK', $permissionResponse);
        $this->assertSame('OK', $roleOrPermissionResponse);
    }

    public function test_superadmin_supera_policies_y_gates_aunque_la_regla_normal_deniegue(): void
    {
        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('hasRole')->with('superadmin')->andReturn(true);

        Gate::define('accion-restringida-de-prueba', fn (User $actor): bool => false);

        $this->assertTrue(Gate::forUser($user)->allows('accion-restringida-de-prueba'));
    }

    public function test_form_request_de_empresa_usa_la_autorizacion_central(): void
    {
        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('hasRole')->with('superadmin')->andReturn(true);

        $request = StoreEmpresaRequest::create('/admin/inmobiliaria/1', 'PUT');
        $request->setUserResolver(fn (): User => $user);

        $this->assertTrue($request->authorize());
    }

    public function test_usuario_sin_privilegios_no_recibe_el_bypass(): void
    {
        $user = $this->mockUser(false);
        $user->shouldReceive('hasAnyRole')->once()->with(['admin'])->andReturn(false);

        $this->expectException(UnauthorizedException::class);

        (new RoleOrSuperadminMiddleware())->handle(
            Request::create('/admin', 'GET'),
            $this->successfulNext(),
            'admin'
        );
    }

    private function mockUser(bool $isSuperadmin): User
    {
        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('hasRole')->with('superadmin')->andReturn($isSuperadmin);

        $guard = Mockery::mock();
        $guard->shouldReceive('user')->andReturn($user);
        Auth::shouldReceive('guard')->with(null)->andReturn($guard);

        return $user;
    }

    private function successfulNext(): Closure
    {
        return fn (Request $request): string => 'OK';
    }
}
