<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

class BuscarUsuario extends Component
{


    use WithPagination;
    use WithFileUploads;

    public $Id = 0, $criterio, $name, $email, $titulo, $telefono, $descripcion, $metadescription, $facebook, $instagram, $whatsapp, $tiktok;
    public $foto, $fotourl, $activo, $rol, $mostrar, $orden, $requiere_aprobacion_propiedades, $new_password_confirmation, $new_password;
    public $editingProtectedSuperadmin = false;
    public $allowSuperadminMutations = false;

    protected $listeners = ['borrarUsuario', 'restaurarUsuario'];
    protected $paginationTheme = 'bootstrap';

    protected array $validationAttributes = [
        'name' => 'nombre',
        'email' => 'correo',
        'telefono' => 'telefono',
        'descripcion' => 'descripcion',
        'new_password' => 'clave',
        'new_password_confirmation' => 'confirmacion de clave',
        'rol' => 'rol',
        'mostrar' => 'visibilidad',
        'orden' => 'orden',
        'requiere_aprobacion_propiedades' => 'aprobacion de propiedades',
        'foto' => 'foto de perfil',
    ];

    protected function messages(): array
    {
        return [
            'new_password.regex' => 'La clave debe incluir mayusculas, minusculas y al menos un numero.',
            'new_password.confirmed' => 'La confirmacion de la clave no coincide.',
            'email.unique' => 'El correo ya esta registrado en otro usuario activo.',
        ];
    }

    public function mount()
    {
        $this->allowSuperadminMutations = User::superadminMutationsAllowed();
        $this->resetForm();
    }

    protected function rulesForStore(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/.*\S.*/'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', Rule::unique('users', 'email')->whereNull('deleted_at')],
            'telefono' => ['required', 'string', 'min:7', 'max:255', 'regex:/.*\S.*/'],
            'descripcion' => ['required', 'string', 'min:10', 'max:10000'],
            'new_password' => ['required', 'string', 'min:8', 'max:72', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'confirmed'],
            'rol' => ['required', Rule::in([0, 1, '0', '1'])],
            'mostrar' => ['nullable', Rule::in([0, 1, '0', '1'])],
            'requiere_aprobacion_propiedades' => ['nullable', Rule::in([0, 1, '0', '1'])],
            'orden' => ['nullable', 'integer', 'between:0,9999'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    protected function rulesForUpdate(int $id): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/.*\S.*/'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', Rule::unique('users', 'email')->whereNull('deleted_at')->ignore($id)],
            'telefono' => ['required', 'string', 'min:7', 'max:255', 'regex:/.*\S.*/'],
            'descripcion' => ['required', 'string', 'min:10', 'max:10000'],
            'rol' => ['required', Rule::in([0, 1, '0', '1'])],
            'mostrar' => ['nullable', Rule::in([0, 1, '0', '1'])],
            'requiere_aprobacion_propiedades' => ['nullable', Rule::in([0, 1, '0', '1'])],
            'orden' => ['nullable', 'integer', 'between:0,9999'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    protected function normalizedText($value, bool $nullable = true): ?string
    {
        $normalized = trim((string) $value);

        if ($nullable && $normalized === '') {
            return null;
        }

        return $normalized;
    }

    protected function applySanitizedState(): void
    {
        $this->name = (string) $this->normalizedText($this->name, false);
        $this->email = mb_strtolower((string) $this->normalizedText($this->email, false));
        $this->telefono = (string) $this->normalizedText($this->telefono, false);
        $this->descripcion = (string) $this->normalizedText($this->descripcion, false);
        $this->titulo = $this->normalizedText($this->titulo);
        $this->metadescription = $this->normalizedText($this->metadescription);
        $this->facebook = $this->normalizedText($this->facebook);
        $this->instagram = $this->normalizedText($this->instagram);
        $this->whatsapp = $this->normalizedText($this->whatsapp);
        $this->tiktok = $this->normalizedText($this->tiktok);
        $this->orden = $this->orden === '' || $this->orden === null ? null : (int) $this->orden;
        $this->rol = (int) $this->rol === 1 ? 1 : 0;
        $this->mostrar = (int) $this->mostrar === 1 ? 1 : 0;
        $this->activo = (int) $this->activo === 1 ? 1 : 0;
        $this->requiere_aprobacion_propiedades = (int) $this->requiere_aprobacion_propiedades === 1 ? 1 : 0;
    }

    protected function currentRules(): array
    {
        return $this->Id ? $this->rulesForUpdate((int) $this->Id) : $this->rulesForStore();
    }

    protected function resetForm(): void
    {
        $this->Id = 0;
        $this->name = '';
        $this->email = '';
        $this->titulo = '';
        $this->telefono = '';
        $this->descripcion = '';
        $this->metadescription = '';
        $this->facebook = '';
        $this->instagram = '';
        $this->whatsapp = '';
        $this->tiktok = '';
        $this->foto = '';
        $this->activo = 1;
        $this->rol = 0;
        $this->mostrar = 1;
        $this->requiere_aprobacion_propiedades = 0;
        $this->orden = 100;
        $this->new_password = '';
        $this->new_password_confirmation = '';
        $this->editingProtectedSuperadmin = false;
    }

    protected function isProtectedSuperadmin(User $usuario): bool
    {
        return $usuario->isConfiguredSuperadmin() && !$this->allowSuperadminMutations;
    }

    protected function syncUserRole(User $usuario): void
    {
        $isAdmin = (int) $this->rol === 1;
        $roleName = $isAdmin ? 'admin' : 'asesor';

        Role::firstOrCreate([
            'name' => $roleName,
            'guard_name' => 'web',
        ]);

        if ($usuario->exists) {
            $usuario->syncRoles([$roleName]);
        }

        $usuario->rol = $isAdmin ? 1 : 0;
    }

    protected function processUploadedPhoto($photo): string
    {
        $fullPath = $photo->store('usuario');
        $absolutePath = public_path('assets/' . $fullPath);

        if (!is_dir(dirname($absolutePath))) {
            mkdir(dirname($absolutePath), 0755, true);
        }

        Image::make($photo)->encode('webp', 90)->fit(600, 600)->save($absolutePath);

        return $fullPath;
    }

    public function updated($propertyName): void
    {
        if ($propertyName === 'new_password_confirmation' && $this->new_password !== '') {
            $this->validateOnly('new_password', [
                'new_password' => ['required', 'string', 'min:8', 'max:72', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'confirmed'],
            ]);

            return;
        }

        $rules = $this->currentRules();
        if (array_key_exists($propertyName, $rules)) {
            $this->validateOnly($propertyName, $rules);
        }
    }

    public function borrarUsuario($id)
    {
        $usuario = User::find((int) $id);
        if (!$usuario) {
            session()->flash('status', 'Usuario no encontrado.');
            return;
        }

        if ($this->isProtectedSuperadmin($usuario)) {
            session()->flash('status', 'Superadmin protegido: no se permite eliminarlo desde la UI.');
            return;
        }

        if ((int) $usuario->id === (int) optional(Auth::user())->id) {
            session()->flash('status', 'No puedes borrar el usuario autenticado.');
            return;
        }

        try {
            DB::transaction(function () use ($usuario): void {
                $usuario->delete();
            });

            session()->flash('status', 'Usuario eliminado exitosamente');
        } catch (Throwable $exception) {
            Log::error('users.delete.failed', [
                'usuario_id' => (int) $id,
                'auth_id' => (int) optional(Auth::user())->id,
                'error' => $exception->getMessage(),
            ]);

            session()->flash('status', 'No fue posible eliminar el usuario. Intenta nuevamente.');
        }
    }

    public function restaurarUsuario($id)
    {
        $usuario = User::onlyTrashed()->find($id);
        if (!$usuario) {
            return;
        }

        try {
            DB::transaction(function () use ($usuario): void {
                $usuario->restore();
            });

            session()->flash('status', 'Usuario restaurado exitosamente');
        } catch (Throwable $exception) {
            Log::error('users.restore.failed', [
                'usuario_id' => (int) $id,
                'auth_id' => (int) optional(Auth::user())->id,
                'error' => $exception->getMessage(),
            ]);

            session()->flash('status', 'No fue posible restaurar el usuario.');
        }
    }

    public function render()
    {
        $term = trim((string) $this->criterio);

        $usuarios = User::query()
            ->when($term !== '', function ($query) use ($term) {
                $query->where(function ($nested) use ($term) {
                    $nested->where('name', 'like', '%' . $term . '%');

                    if (ctype_digit($term)) {
                        $nested->orWhere('id', (int) $term);
                    }
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $usuariosEliminados = User::onlyTrashed()->orderBy('deleted_at', 'desc')->get();

        return view('livewire.buscar-usuario', compact('usuarios', 'usuariosEliminados'));
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return;
        }

        $this->name = $usuario->name;
        $this->email = $usuario->email;
        $this->titulo = $usuario->titulo;
        $this->telefono = $usuario->telefono;
        $this->descripcion = $usuario->descripcion;
        $this->metadescription = $usuario->metadescription;
        $this->facebook = $usuario->facebook;
        $this->instagram = $usuario->instagram;
        $this->whatsapp = $usuario->whatsapp;
        $this->tiktok = $usuario->tiktok;
        $this->foto = $usuario->foto;
        $this->activo = $usuario->activo;
        $this->rol = $usuario->rol;
        $this->mostrar = $usuario->mostrar;
        $this->requiere_aprobacion_propiedades = (int) ($usuario->requiere_aprobacion_propiedades ?? 0) === 1 ? 1 : 0;
        $this->orden = $usuario->orden;
        $this->Id = $id;
        $this->editingProtectedSuperadmin = $this->isProtectedSuperadmin($usuario);

        $this->emit('editarDescripcion', $usuario->descripcion);
    }

    public function store()
    {
        $this->applySanitizedState();
        $this->validate($this->rulesForStore());

        try {
            DB::transaction(function (): void {
                $usuario = new User();
                $usuario->name = $this->name;
                $usuario->email = $this->email;
                $usuario->password = Hash::make((string) $this->new_password);
                $usuario->telefono = $this->telefono;
                $usuario->descripcion = $this->descripcion;
                $usuario->metadescription = $this->metadescription;
                $usuario->titulo = $this->titulo;
                $usuario->facebook = $this->facebook;
                $usuario->instagram = $this->instagram;
                $usuario->whatsapp = $this->whatsapp;
                $usuario->tiktok = $this->tiktok;
                $usuario->orden = $this->orden;
                $usuario->mostrar = $this->mostrar;
                $usuario->activo = $this->activo;
                $usuario->rol = $this->rol;
                $usuario->requiere_aprobacion_propiedades = $this->requiere_aprobacion_propiedades;

                if ($this->foto) {
                    $usuario->foto = is_string($this->foto)
                        ? $this->foto
                        : $this->processUploadedPhoto($this->foto);
                }

                $usuario->save();
                $this->syncUserRole($usuario);
            });

            session()->flash('status', 'Usuario creado exitosamente');
            $this->dispatchBrowserEvent('close-modal');
            $this->resetForm();
            $this->emit('limpiarDescripcion');
        } catch (Throwable $exception) {
            Log::error('users.store.failed', [
                'email' => (string) $this->email,
                'auth_id' => (int) optional(Auth::user())->id,
                'error' => $exception->getMessage(),
            ]);

            $this->addError('name', 'No fue posible crear el usuario. Valida los datos e intenta nuevamente.');
        }
    }

    public function clear()
    {
        $this->resetForm();
        $this->resetErrorBag();
        $this->resetValidation();

        $this->emit('limpiarDescripcion');
    }

    public function openCreateModal(): void
    {
        $this->clear();
        $this->dispatchBrowserEvent('open-user-modal');
    }

    public function borrar_foto()
    {
        $this->foto = '';
    }

    public function update($id)
    {
        $this->applySanitizedState();
        $this->validate($this->rulesForUpdate((int) $id));

        if ($this->new_password !== '') {
            $this->validate([
                'new_password' => ['string', 'min:8', 'max:72', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'confirmed'],
            ]);
        }

        $usuario = User::where("id", $id)->first();
        if (!$usuario) {
            return;
        }

        try {
            DB::transaction(function () use ($usuario): void {
                $usuario->name = $this->name;
                $usuario->email = $this->email;
                $usuario->telefono = $this->telefono;
                $usuario->descripcion = $this->descripcion;
                $usuario->metadescription = $this->metadescription;
                $usuario->titulo = $this->titulo;
                $usuario->facebook = $this->facebook;
                $usuario->instagram = $this->instagram;
                $usuario->whatsapp = $this->whatsapp;
                $usuario->tiktok = $this->tiktok;
                $usuario->orden = $this->orden;
                $usuario->mostrar = $this->mostrar;
                $usuario->requiere_aprobacion_propiedades = $this->requiere_aprobacion_propiedades;
                $usuario->activo = $this->editingProtectedSuperadmin ? 1 : $this->activo;

                $this->syncUserRole($usuario);

                if ($this->new_password !== '') {
                    $usuario->password = Hash::make((string) $this->new_password);
                }

                if ($this->foto != $usuario->foto && $this->foto != '') {
                    $usuario->foto = is_string($this->foto)
                        ? $this->foto
                        : $this->processUploadedPhoto($this->foto);
                } else {
                    $usuario->foto = $this->foto;
                }

                $usuario->save();
            });

            if ($this->editingProtectedSuperadmin) {
                session()->flash('status', 'Usuario actualizado. El superadmin protegido se mantiene activo.');
            } else {
                session()->flash('status', 'Usuario actualizado exitosamente');
            }

            $this->dispatchBrowserEvent('close-modal');
            $this->resetForm();
            $this->emit('limpiarDescripcion');
        } catch (Throwable $exception) {
            Log::error('users.update.failed', [
                'usuario_id' => (int) $id,
                'auth_id' => (int) optional(Auth::user())->id,
                'error' => $exception->getMessage(),
            ]);

            $this->addError('name', 'No fue posible actualizar el usuario. Intenta nuevamente.');
        }
    }
}
