<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TiposDePropiedad;
use Illuminate\Http\Request;

class TiposPropiedadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * 
     */
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $tipopropiedades = TiposDePropiedad::Paginate(5);

        return view("admin.tipopropiedades.index",compact("tipopropiedades"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.tipopropiedades.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required'            
        ]);

        $tipopropiedades = New TiposDePropiedad();

        $tipopropiedades->tipo = $request->tipo;

        $tipopropiedades->save();

        return redirect()->route("tipopropiedades.index");        

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
        $tipopropiedad = TiposDePropiedad::where('id',$id)->first();

        return view("admin.tipopropiedades.edit", compact("tipopropiedad"));

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
        $request->validate([
            'tipo' => 'required'              
        ]);

        $tipopropiedad = TiposDePropiedad::where('id',$id)->first();              

        $tipopropiedad->tipo = $request->tipo;

        $tipopropiedad->save();

        return redirect()->route("tipopropiedades.index");         

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipopropiedad = TiposDePropiedad::where('id',$id)->first();
        $tipopropiedad->delete();

        return redirect()->route("tipopropiedades.index");
    }
}
