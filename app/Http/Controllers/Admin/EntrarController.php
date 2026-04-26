<?php

namespace App\Http\Controllers\Admin;

use session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

            if (Auth::user()->activo == 0) {
                session()->flash('error', 'Al parecer su usuario no esta activo, comuniquese con el Administrador');
                return redirect()->back();
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
        ]);

        Role::firstOrCreate([
            'name' => 'asesor',
            'guard_name' => 'web',
        ]);
        $usuario->syncRoles(['asesor']);

        return redirect()->route('login');
    }
}
