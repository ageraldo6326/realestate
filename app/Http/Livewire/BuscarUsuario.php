<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

class BuscarUsuario extends Component
{


    use WithPagination;
    use WithFileUploads;

    public $Id = 0, $criterio, $name, $email, $titulo, $telefono, $descripcion, $metadescription, $facebook, $instagram, $whatsapp, $tiktok;
    public $foto, $fotourl, $activo, $rol, $mostrar, $orden, $new_password_confirmation, $new_password;

    protected $listeners = ['borrarUsuario'];
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->resetForm();
    }

    protected function rulesForStore(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'telefono' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            'rol' => ['required', Rule::in([0, 1, '0', '1'])],
            'mostrar' => ['nullable', Rule::in([0, 1, '0', '1'])],
            'orden' => ['nullable', 'integer'],
            'foto' => ['nullable'],
        ];
    }

    protected function rulesForUpdate(int $id): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($id)],
            'telefono' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'rol' => ['required', Rule::in([0, 1, '0', '1'])],
            'mostrar' => ['nullable', Rule::in([0, 1, '0', '1'])],
            'orden' => ['nullable', 'integer'],
            'foto' => ['nullable'],
        ];
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
        $this->rol = null;
        $this->mostrar = 1;
        $this->orden = 100;
        $this->new_password = '';
        $this->new_password_confirmation = '';
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

    public function borrarUsuario($id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return;
        }

        if ((int) $usuario->id === (int) optional(Auth::user())->id) {
            session()->flash('status', 'No puedes borrar el usuario autenticado.');
            return;
        }

        $usuario->delete();

        session()->flash('status', 'Usuario eliminado exitosamente');
    }

    public function render()
    {
        $usuarios = User::where('name', 'like', '%' . $this->criterio . '%')
            ->OrWhere('id', '=', $this->criterio)
            ->orderby('id', 'desc')->paginate(10);

        return view('livewire.buscar-usuario', compact('usuarios'));
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
        $this->orden = $usuario->orden;
        $this->Id = $id;

        $this->emit('editarDescripcion', $usuario->descripcion);
    }

    public function store()
    {
        $this->validate($this->rulesForStore());

        $usuario = new User();
        $usuario->name = $this->name;
        $usuario->email = $this->email;
        $usuario->password = Hash::make($this->new_password);
        $usuario->telefono = $this->telefono;
        $usuario->descripcion = $this->descripcion;
        $usuario->metadescription = $this->metadescription;
        $usuario->titulo = $this->titulo;
        $usuario->facebook = $this->facebook;
        $usuario->instagram = $this->instagram;
        $usuario->whatsapp = $this->whatsapp;
        $usuario->tiktok = $this->tiktok;
        $usuario->orden = $this->orden;
        $usuario->mostrar = (int) $this->mostrar === 1 ? 1 : 0;
        $usuario->activo = (int) $this->activo === 1 ? 1 : 0;
        $usuario->rol = (int) $this->rol === 1 ? 1 : 0;

        if ($this->foto) {
            $usuario->foto = is_string($this->foto)
                ? $this->foto
                : $this->processUploadedPhoto($this->foto);
        }

        $usuario->save();
        $this->syncUserRole($usuario);

        session()->flash('status', 'Usuario creado exitosamente');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetForm();
        $this->emit('limpiarDescripcion');
    }

    public function clear()
    {
        $this->resetForm();
        $this->resetValidation();

        $this->emit('limpiarDescripcion');
    }

    public function borrar_foto()
    {
        $this->foto = '';
    }

    public function update($id)
    {
        $this->validate($this->rulesForUpdate((int) $id));

        if ($this->new_password !== '') {
            $this->validate([
                'new_password' => ['string', 'min:8', 'confirmed'],
            ]);
        }

        $usuario = User::where("id", $id)->first();
        if (!$usuario) {
            return;
        }

        $usuario->name = $this->name;
        $usuario->email = $this->email;
        $usuario->telefono = $this->telefono;
        $usuario->descripcion = $this->descripcion;
        $usuario->metadescription = $this->metadescription;
        $usuario->titulo =  $this->titulo;
        $usuario->facebook = $this->facebook;
        $usuario->instagram = $this->instagram;
        $usuario->whatsapp = $this->whatsapp;
        $usuario->tiktok = $this->tiktok;
        $usuario->orden = $this->orden;
        $usuario->mostrar = $this->mostrar;
        $usuario->activo = $this->activo;

        $this->syncUserRole($usuario);

        if ($this->new_password != "" and ($this->new_password == $this->new_password_confirmation)) {

            $usuario->password = Hash::make($this->new_password);
        }

        if ($this->foto != $usuario->foto and $this->foto != "") {
            $usuario->foto = is_string($this->foto)
                ? $this->foto
                : $this->processUploadedPhoto($this->foto);
        } else {

            $usuario->foto = $this->foto;
        }

        $usuario->save();

        session()->flash('status', 'Usuario actualizado exitosamente');

        $this->dispatchBrowserEvent('close-modal');
        $this->resetForm();
        $this->emit('limpiarDescripcion');
    }
}
