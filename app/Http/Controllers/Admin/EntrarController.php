<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EntrarController extends Controller
{
    //

    public function login(Request $request)
    {


        $message = array(
            'required.email'    =>  'This is required',
            'required.password' =>  'This is required',
        );

        $this->validate($request, [
            'email' =>  'required',
            'password'  =>  'required',
        ], $message);

        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            /** @var User $authUser */
            $authUser = Auth::user();

            if ((int) $authUser->activo === 0) {
                Auth::logout();
                session()->flash('error', 'Al parecer su usuario no esta activo, comuniquese con el Administrador');
                return redirect()->back();
            }

            if (
                (bool) config('security.enforce_superadmin_password_rotation', true)
                && $authUser->isConfiguredSuperadmin()
                && $authUser->usesBootstrapSuperadminPassword()
            ) {
                session()->flash('warning', 'Por seguridad debes cambiar la clave inicial del superadmin.');

                return redirect()->route('admin.superadmin.password.edit');
            }

            session()->flash('success', 'Welcome ' . Auth::user()->name);
            return redirect('/admin/dashboard/');
        } else {
            session()->flash('error', 'Lo siento al parecer hay un error en sus credenciales.');
            return redirect()->back();
        }
    }

    public function registrarse(Request $data)
    {

        $message = array(
            'required.name'    =>  'This is required',
            'required.email'    =>  'This is required',
            'required.password' =>  'This is required',
        );


        $this->validate($data, [
            'name' =>  'required',
            'email' =>  'required',
            'password'  =>  'required',
        ], $message);


        $usuario = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'rol' => 0,
            'activo' => 1,
            'mostrar' => 1,
            'orden' => 100,
            'requiere_aprobacion_propiedades' => $data->boolean('requiere_aprobacion_propiedades'),
        ]);

        Role::firstOrCreate([
            'name' => 'asesor',
            'guard_name' => 'web',
        ]);
        $usuario->syncRoles(['asesor']);

        return redirect()->route('login');
    }

    public function showSuperadminPasswordRotationForm()
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user || !$user->isConfiguredSuperadmin()) {
            return redirect()->route('dashboard');
        }

        if (!$user->usesBootstrapSuperadminPassword()) {
            return redirect()->route('dashboard');
        }

        return view('admin.security.rotate-superadmin-password');
    }

    public function rotateSuperadminPassword(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || !$user->isConfiguredSuperadmin()) {
            abort(403);
        }

        if (!$user->usesBootstrapSuperadminPassword()) {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $newPassword = (string) $request->input('new_password');
        $bootstrapPassword = trim((string) config('security.superadmin_bootstrap_password', ''));

        if ($bootstrapPassword !== '' && hash_equals($bootstrapPassword, $newPassword)) {
            return redirect()
                ->back()
                ->withErrors(['new_password' => 'La nueva clave debe ser diferente a la clave inicial del .env.'])
                ->withInput();
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        session()->flash('success', 'Clave actualizada correctamente. Ya puedes continuar en el panel.');

        return redirect()->route('dashboard');
    }
}
