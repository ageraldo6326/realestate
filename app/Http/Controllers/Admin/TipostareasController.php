<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ToDoTipo;
use Illuminate\Http\Request;

class TipostareasController extends Controller
{
   public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $tipostareas = ToDoTipo::Paginate(20);

        return view("admin.tipotarea.index",compact("tipostareas"));
    }

    public function create()
    {
        //
        return view("admin.tipotarea.create");
    }


    public function store(Request $request)
    {
        $request->validate([
            'todo_tipo' => 'required'            
        ]);

        $tipostareas = New ToDoTipo();

        $tipostareas->todo_tipo = $request->todo_tipo;
        $tipostareas->color = $request->color;

        $tipostareas->save();

        return redirect()->route("tipostareas.index")->with('status', 'Tipo de Tarea Agregada');        

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $tipotarea = ToDoTipo::where('id',$id)->first();

        return view("admin.tipotarea.edit", compact("tipotarea"));

    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'todo_tipo' => 'required'              
        ]);

        $tipostareas = ToDoTipo::where('id',$id)->first();              

        $tipostareas->todo_tipo = $request->todo_tipo;
        $tipostareas->color = $request->color;

        $tipostareas->save();

        return redirect()->route("tipostareas.index")->with('status', 'Tipo de Tarea Actualizada');         

    }

    public function destroy($id)
    {
        $tipostareas = ToDoTipo::where('id',$id)->first();
        $tipostareas->delete();

        return redirect()->route("tipostareas.index")->with('status', 'Tipo de Tarea Eliminada');
    }
}
