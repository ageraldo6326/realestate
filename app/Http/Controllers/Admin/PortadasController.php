<?php

namespace App\Http\Controllers\Admin;

use App\Models\Portada;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class PortadasController extends Controller
{
    //

    public function __construct(){
    $this->middleware('auth');
    }

    public function index() {

        $portadas = Portada::paginate(5);

        return view('admin.portadas.index',compact('portadas'));

    }

    public function create() {

        return view('admin.portadas.create');
    }

    public function store(Request $request) {


            $request->validate([
                'foto' => 'required',
                'titulo' => 'required',
                'minititulo' => 'required',                
                'descripcion' => 'required'
            ]);

            
            $portada = New Portada();

            if ($request->hasFile('foto')) {

                $urlfoto = $request->file("foto");
    
                $portada->foto = '/img/portada/' . $request->file("foto")->getClientOriginalName(); 
                
                $ruta = public_path('/img/portada/').$request->file("foto")->getClientOriginalName();
            
                copy($urlfoto->getRealPath(),$ruta);
            }            


            $portada->minititulo = $request->minititulo;
            $portada->titulo = $request->titulo;
            $portada->descripcion = $request->descripcion;
            $portada->url1 = $request->url1;
            $portada->url2 = $request->url2;
            $portada->enlace1 = $request->enlace1;
            $portada->enlace2 = $request->enlace2;
            $portada->video=str_replace('watch?v=','embed/',$request->video);
            $portada->save();

            return Redirect::route('portadas.index');

    }

    public function destroy($id)
    {
        $portada = Portada::where('id',$id)->first();
        $portada->delete();

        return redirect()->route("portadas.index");
    }

    public function edit($id) {

        $portada = Portada::where('id',$id)->first();
        
        return view('admin.portadas.edit',compact('portada'));

    }

    public function update(Request $request, $id){



            $request->validate([
                'titulo' => 'required',
                'minititulo' => 'required',                
                'descripcion' => 'required'
            ]);

            
            $portada = Portada::where('id',$id)->first();

            if ($request->hasFile('foto')) {

                $urlfoto = $request->file("foto");
    
                $portada->foto = '/img/portada/' . $request->file("foto")->getClientOriginalName(); 
                
                $ruta = public_path('/img/portada/').$request->file("foto")->getClientOriginalName();
            
                copy($urlfoto->getRealPath(),$ruta);
            }            


            $portada->minititulo = $request->minititulo;
            $portada->titulo = $request->titulo;
            $portada->descripcion = $request->descripcion;
            $portada->url1 = $request->url1;
            $portada->url2 = $request->url2;
            $portada->enlace1 = $request->enlace1;
            $portada->enlace2 = $request->enlace2;
            $portada->video=str_replace('watch?v=','embed/',$request->video);
            $portada->save();

            return Redirect::route('portadas.index');


    }


}
