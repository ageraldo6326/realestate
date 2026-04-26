<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    //

    // public function __construct(){
    // $this->middleware('auth');
    // }

    public function login() {
        return view('admin.login');
    }


    public function index()
    {
        //
        $usuarios = User::all();
        

        return view("admin.usuarios.index",compact("usuarios"));
    }


    public function update(Request $request, $id)
    {
        //dd($request);
        
         $validated = $request->validate([
        'telefono' => 'required',
        'descripcion' => 'required',
        ]);

        $usuario = User::where("id",$id)->first();
        $usuario->telefono = $request->telefono;
        $usuario->descripcion = $request->descripcion;
        $usuario->metadescription = $request->metadescription;
        $usuario->titulo =  $request->titulo;
        $usuario->facebook = $request->facebook;
        $usuario->instagram = $request->instagram;
        $usuario->whatsapp = $request->whatsapp;
        $usuario->tiktok = $request->tiktok;
        $usuario->rol = $request->rol;
        $usuario->orden = $request->orden;
        $usuario->mostrar = $request->mostrar;

        if ($request->has("estado")) {
            $usuario->activo = 1;
        } else {
            $usuario->activo = 0;
        }

        if ($request->new_password !="" and ( $request->new_password == $request->new_password_confirmation )) {

            $usuario->password = Hash::make($request->new_password);        
        }
        

        if ($request->hasFile('fotourl')) {

            $urlfoto = $request->file("fotourl");
  
            $usuario->foto = '/img/usuario/' . $request->file("fotourl")->getClientOriginalName(); 
              
            $ruta = public_path('/img/usuario/').$request->file("fotourl")->getClientOriginalName();
          
            copy($urlfoto->getRealPath(),$ruta);
        }
 

        $usuario->save();

        return redirect()->route("usuarios.index");

        
    }

    public function edit($id)
    {
        //

        $usuario = User::Where('id',$id)->first();
        
        return view("admin.usuarios.edit", compact("usuario"));
    }

    public function borrarusuario($id) {
        dd($id);
        $propiedad = User::where('id','=',$id);
        $propiedad->delete();         
        return back()->with('borrarusuario', 'Usuario '.$id . ' borrado!');       
    }

}
