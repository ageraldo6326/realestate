<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zonas;
use Illuminate\Http\Request;

class ZonasController extends Controller
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
        $zonas = Zonas::Paginate(5);

        return view("admin.zonas.index",compact("zonas"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.zonas.create");
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
            'zona' => 'required'            
        ]);

        $zona = New Zonas();

        $zona->zona = $request->zona;

        $zona->save();

        return redirect()->route("zonas.index");        

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
        $zona = Zonas::where('id',$id)->first();

        return view("admin.zonas.edit", compact("zona"));

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
            'zona' => 'required'              
        ]);

        $zona = Zonas::where('id',$id)->first();              

        $zona->zona = $request->zona;

        $zona->save();

        return redirect()->route("zonas.index");         

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $zona = Zonas::where('id',$id)->first();
        $zona->delete();

        return redirect()->route("zonas.index");
    }
}
