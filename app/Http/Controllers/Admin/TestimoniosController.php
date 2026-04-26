<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonio;
use Illuminate\Http\Request;

class TestimoniosController extends Controller
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
        $testimonios = Testimonio::all();

        return view("admin.testimonios.index",compact("testimonios"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.testimonios.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //
        $request->validate([
            'cliente' => 'required',
            'testimonio' => 'required|min:10|max:500',                
        ]);

  
        $testimonio = New Testimonio();

        $testimonio->cliente = $request->cliente;
        $testimonio->testimonio = $request->testimonio;

        if ($request->hasFile('cliente_foto')) {

            $urlfoto = $request->file("cliente_foto");
  
            $testimonio->cliente_foto = '/img/testimonio/' . $request->file("cliente_foto")->getClientOriginalName(); 
              
            $ruta = public_path('/img/testimonio/').$request->file("cliente_foto")->getClientOriginalName();
          
            copy($urlfoto->getRealPath(),$ruta);
        }        

        $testimonio->save();

        return redirect()->route("testimonios.index");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $testimonio = Testimonio::where('id',$id)->first();

        return view("admin.testimonios.edit", compact("testimonio"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //


        $request->validate([
            'cliente' => 'required',
            'testimonio' => 'required',                
        ]);

        $testimonio = Testimonio::where('id',$id)->first();
              

        $testimonio->cliente = $request->cliente;
        $testimonio->testimonio = $request->testimonio;

       

        if ($request->hasFile('cliente_foto')) {

            $urlfoto = $request->file("cliente_foto");
  
            $testimonio->cliente_foto = '/img/testimonio/' . $request->file("cliente_foto")->getClientOriginalName(); 
              
            $ruta = public_path('/img/testimonio/').$request->file("cliente_foto")->getClientOriginalName();
          
            copy($urlfoto->getRealPath(),$ruta);
        }        

 

        $testimonio->save();

        return redirect()->route("testimonios.index");        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $testimonio = Testimonio::where('id',$id)->first();
        $testimonio->delete();

        return redirect()->route("testimonios.index");

    }
}
