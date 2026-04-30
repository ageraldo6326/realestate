<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Throwable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsuarioRequest;
use App\Http\Requests\Admin\UpdateUsuarioRequest;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

/**
 * Controlador para gestión de usuarios en el panel administrativo.
 * Implementa CRUD con validación centralizada, transacciones y logs.
 * Roles requeridos: admin (para todos los métodos)
 */
class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function login()
    {
        return view('admin.login');
    }

    public function index()
    {
        $usuarios = User::query()->orderByDesc('id')->paginate(50);
        return view("admin.usuarios.index", compact("usuarios"));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(StoreUsuarioRequest $request)
    {
        $validated = $request->validated();

        try {
            $newUser = DB::transaction(function () use ($validated, $request): User {
                $usuario = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['new_password']),
                    'telefono' => $validated['telefono'],
                    'descripcion' => $validated['descripcion'],
                    'metadescription' => $validated['metadescription'],
                    'titulo' => $validated['titulo'],
                    'facebook' => $validated['facebook'],
                    'instagram' => $validated['instagram'],
                    'whatsapp' => $validated['whatsapp'],
                    'tiktok' => $validated['tiktok'],
                    'rol' => (int) $validated['rol'],
                    'mostrar' => (int) $validated['mostrar'],
                    'activo' => (int) $validated['activo'],
                    'orden' => $validated['orden'],
                    'requiere_aprobacion_propiedades' => (int) $validated['requiere_aprobacion_propiedades'],
                ]);

                $roleName = (int) $validated['rol'] === 1 ? 'admin' : 'asesor';
                Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
                $usuario->syncRoles([$roleName]);

                if ($request->hasFile('fotourl')) {
                    $foto = $this->processUploadedPhoto($request->file('fotourl'));
                    $usuario->update(['foto' => $foto]);
                }

                return $usuario;
            });

            Log::info('users.created.success', [
                'usuario_id' => $newUser->id,
                'usuario_name' => $newUser->name,
                'usuario_email' => $newUser->email,
                'created_by' => (int) optional($request->user())->id,
            ]);

            return redirect()->route('usuarios.index')
                ->with('status', 'Usuario ' . $newUser->name . ' creado exitosamente.');
        } catch (Throwable $exception) {
            Log::error('users.create.failed', [
                'email' => $validated['email'] ?? null,
                'name' => $validated['name'] ?? null,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'created_by' => (int) optional($request->user())->id,
            ]);

            return redirect()->route('usuarios.create')
                ->withInput()
                ->with('error', 'No fue posible crear el usuario. ' . ($exception->getMessage() ?? 'Error desconocido'));
        }
    }

    public function edit($id)
    {
        $usuario = User::query()->find((int) $id);
        if (!$usuario) {
            return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado.');
        }

        return view("admin.usuarios.edit", compact("usuario"));
    }

    public function update(UpdateUsuarioRequest $request, $id)
    {
        $usuario = User::query()->find((int) $id);
        if (!$usuario) {
            return redirect()->route("usuarios.index")->with('error', 'Usuario no encontrado.');
        }

        $validated = $request->validated();
        $isProtectedSuperadmin = $usuario->isConfiguredSuperadmin() && !User::superadminMutationsAllowed();

        try {
            DB::transaction(function () use ($usuario, $validated, $request, $isProtectedSuperadmin): void {
                $usuario->update([
                    'telefono' => $validated['telefono'],
                    'descripcion' => $validated['descripcion'],
                    'metadescription' => $validated['metadescription'],
                    'titulo' => $validated['titulo'],
                    'facebook' => $validated['facebook'],
                    'instagram' => $validated['instagram'],
                    'whatsapp' => $validated['whatsapp'],
                    'tiktok' => $validated['tiktok'],
                    'rol' => (int) $validated['rol'],
                    'orden' => $validated['orden'],
                    'mostrar' => (int) $validated['mostrar'],
                    'requiere_aprobacion_propiedades' => $this->resolveApprovalMode(
                        $validated['modo_aprobacion_propiedades'] ?? 'system'
                    ),
                    'activo' => $isProtectedSuperadmin ? 1 : ((int) ($validated['estado'] ?? 0)),
                ]);

                $newRoleName = (int) $validated['rol'] === 1 ? 'admin' : 'asesor';
                Role::firstOrCreate(['name' => $newRoleName, 'guard_name' => 'web']);
                $usuario->syncRoles([$newRoleName]);

                if (!empty($validated['new_password'])) {
                    $usuario->update(['password' => Hash::make($validated['new_password'])]);
                }

                if ($request->hasFile('fotourl')) {
                    $foto = $this->processUploadedPhoto($request->file('fotourl'));
                    $usuario->update(['foto' => $foto]);
                }
            });

            Log::info('users.updated.success', [
                'usuario_id' => (int) $id,
                'usuario_email' => $usuario->email,
                'updated_by' => (int) optional($request->user())->id,
                'protected_superadmin' => $isProtectedSuperadmin,
            ]);

            if ($isProtectedSuperadmin) {
                return redirect()->route("usuarios.index")
                    ->with('status', 'Superadmin protegido: estado no modificado.');
            }

            return redirect()->route("usuarios.index")
                ->with('status', 'Usuario actualizado correctamente.');
        } catch (Throwable $exception) {
            Log::error('users.update.failed', [
                'usuario_id' => (int) $id,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'updated_by' => (int) optional($request->user())->id,
            ]);

            return redirect()->route('usuarios.edit', ['usuario' => (int) $id])
                ->withInput()
                ->with('error', 'No fue posible actualizar el usuario. Intenta nuevamente.');
        }
    }

    public function destroy(Request $request, $id)
    {
        $usuario = User::query()->find((int) $id);
        if (!$usuario) {
            return back()->with('error', 'Usuario no encontrado.');
        }

        if ($usuario->isConfiguredSuperadmin() && !User::superadminMutationsAllowed()) {
            return back()->with('error', 'Superadmin protegido: no se permite eliminarlo.');
        }

        if ((int) $usuario->id === (int) optional($request->user())->id) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        try {
            DB::transaction(function () use ($usuario): void {
                $usuario->delete();
            });

            Log::info('users.deleted.success', [
                'usuario_id' => (int) $id,
                'usuario_email' => $usuario->email,
                'deleted_by' => (int) optional($request->user())->id,
            ]);

            return back()->with('status', 'Usuario eliminado exitosamente.');
        } catch (Throwable $exception) {
            Log::error('users.delete.failed', [
                'usuario_id' => (int) $id,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'deleted_by' => (int) optional($request->user())->id,
            ]);

            return back()->with('error', 'No fue posible eliminar el usuario. Intenta nuevamente.');
        }
    }

    public function borrarusuario(Request $request, $id)
    {
        return $this->destroy($request, $id);
    }

    private function processUploadedPhoto($photo): string
    {
        try {
            $filename = Str::uuid()->toString() . '.webp';
            $directory = public_path('assets/usuario');

            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            Image::make($photo)
                ->fit(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 90)
                ->save($directory . '/' . $filename);

            return '/assets/usuario/' . $filename;
        } catch (Throwable $exception) {
            Log::warning('photo_processing.failed', [
                'error' => $exception->getMessage(),
                'original_name' => $photo->getClientOriginalName() ?? 'unknown',
            ]);

            return '/assets/usuario/default.webp';
        }
    }

    private function resolveApprovalMode(string $mode): ?int
    {
        return match ($mode) {
            'required' => 1,
            'skip' => 0,
            default => null,
        };
    }
}
