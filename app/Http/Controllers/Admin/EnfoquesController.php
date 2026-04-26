<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enfoque;
use Illuminate\Support\Facades\Auth;

class EnfoquesController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enfoques = Enfoque::all();

        return view("admin.enfoques.index",compact("enfoques"));
    }

    public function edit($id)
    {
        //
        $enfoque = Enfoque::where('id',$id)->first();

        return view("admin.enfoques.edit", compact("enfoque"));
    }

    public function update(Request $request, $id)
    {
        //


        $request->validate([
            'titulo' => 'required',
            'enfoque' => 'required'             
        ]);

        $enfoque = Enfoque::where('id',$id)->first();
              

        $enfoque->titulo = $request->titulo;
        $enfoque->enfoque = $request->enfoque;   
        
        if ($request->hasFile('foto')) {

            $urlfoto = $request->file("foto");

            $enfoque->foto = '/img/enfoque/' . $request->file("foto")->getClientOriginalName(); 
            
            $ruta = public_path('/img/enfoque/').$request->file("foto")->getClientOriginalName();
        
            copy($urlfoto->getRealPath(),$ruta);
        }          
 
        $enfoque->save();

        return redirect()->route("enfoques.index");        
    }

    public function create() {
        return view('admin.enfoques.create');
    }

    public function destroy($id) {
        $enfoque = Enfoque::where('id',$id)->first();
        $enfoque->delete();
        return redirect()->route("enfoques.index");

    }

    public function store(Request $request)
    {
        //


        $request->validate([
            'titulo' => 'required',
            'enfoque' => 'required'             
        ]);

        $enfoque = new Enfoque();
              

        $enfoque->titulo = $request->titulo;
        $enfoque->enfoque = $request->enfoque; 
        
        if ($request->hasFile('foto')) {

            $urlfoto = $request->file("foto");

            $enfoque->foto = '/img/enfoque/' . $request->file("foto")->getClientOriginalName(); 
            
            $ruta = public_path('/img/enfoque/').$request->file("foto")->getClientOriginalName();
        
            copy($urlfoto->getRealPath(),$ruta);
        }          
 
        $enfoque->save();

        return redirect()->route("enfoques.index");        
    }    


}
