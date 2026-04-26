<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disponible_para;
use Illuminate\Http\Request;

class DisponibleParaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * 
     */
    public function __construct(){
        $this->middleware(['auth']);
    }

    public function index()
    {
        $disponiblespara = Disponible_para::Paginate(5);

        return view("admin.disponiblepara.index",compact("disponiblespara"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.disponiblepara.create");
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
            'disponible_para' => 'required'            
        ]);

        $disponiblespara = New Disponible_para();

        $disponiblespara->disponible_para = $request->disponible_para;

        $disponiblespara->save();

        return redirect()->route("disponiblepara.index");        

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
        $disponiblespara = Disponible_para::where('id',$id)->first();

        return view("admin.disponiblepara.edit", compact("disponiblespara"));

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
            'disponible_para' => 'required'              
        ]);

        $disponiblespara = Disponible_para::where('id',$id)->first();              

        $disponiblespara->disponible_para = $request->disponible_para;

        $disponiblespara->save();

        return redirect()->route("disponiblepara.index");         

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $disponiblespara = Disponible_para::where('id',$id)->first();
        $disponiblespara->delete();

        return redirect()->route("disponiblepara.index");
    }
}
