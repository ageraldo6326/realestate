<?php

namespace App\Http\Controllers\Admin;

use App\Models\ToDo;
use App\Models\ToDoTipo;
use App\Models\ToDoEstatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function calendario()
    {

        $tareas = DB::table('to_dos')
            ->select('to_dos.id', 'to_dos.nombre', 'descripcion', 'fechaLimite', 'to_do_tipos.todo_tipo', 'to_do_estatuses.todo_estatus', 'user_id', 'cliente_id', 'clientes.nombre as cliente', 'color')
            ->leftJoin('to_do_estatuses', 'to_dos.todo_estatus', '=', 'to_do_estatuses.id')
            ->leftJoin('to_do_tipos', 'to_dos.todo_tipo', '=', 'to_do_tipos.id')
            ->leftJoin('clientes', 'to_dos.cliente_id', '=', 'clientes.id')
            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('fechaLimite', 'desc')
            ->get();

        $eventos = [];

        foreach ($tareas as $tarea) {
            $eventos[] = [
                'title' => trim(($tarea->todo_tipo ?? 'Tarea') . ' - ' . ($tarea->nombre ?? 'Sin titulo')),
                'start' => $tarea->fechaLimite,
                'end' => $tarea->fechaLimite,
                'color' => $tarea->color,
            ];
        }


        return view('admin.todos.calendario', compact('eventos', 'tareas'));
    }

    public function index()
    {

        $tareas = DB::table('to_dos')
            ->select('to_dos.id', 'to_dos.nombre', 'descripcion', 'fechaLimite', 'to_do_tipos.todo_tipo', 'to_do_estatuses.todo_estatus', 'to_do_tipos.color', 'user_id', 'cliente_id', 'clientes.nombre as cliente')
            ->leftJoin('to_do_estatuses', 'to_dos.todo_estatus', '=', 'to_do_estatuses.id')
            ->leftJoin('to_do_tipos', 'to_dos.todo_tipo', '=', 'to_do_tipos.id')
            ->leftJoin('clientes', 'to_dos.cliente_id', '=', 'clientes.id')
            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('fechaLimite', 'desc')
            ->get();

        return view('admin.todos.index', compact('tareas'));
    }

    public function create()
    {

        $tipos = ToDoTipo::all();
        $estatuses = ToDoEstatus::all();
        $clientes = Clientes::where(function ($query) {
            $query->where('captado_por', Auth::id())
                ->orWhere('asignado_a', Auth::id());
        })->get();

        return view('admin.todos.create', compact('clientes', 'tipos', 'estatuses'));
    }

    public function update(Request $request, $id)
    {

        $tarea = ToDo::find($id);

        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'todo_tipo' => 'required',
            'fechaLimite' => 'required',
            'cliente_id' => 'required'
        ]);

        // dd($request);

        $tarea->nombre = $request->nombre;
        $tarea->descripcion = $request->descripcion;
        $tarea->fechaLimite = str_replace('T', ' ', $request->fechaLimite);
        $tarea->todo_estatus = $request->todo_estatus;
        $tarea->todo_tipo = $request->todo_tipo;
        $tarea->cliente_id = $request->cliente_id;

        $tarea->save();

        return redirect('/admin/todo')->with('status', 'Tarea Actualizada Exitosamente!');
    }

    public function edit($id)
    {

        $tarea = ToDo::find($id);
        $tipos = ToDoTipo::all();
        $estatuses = ToDoEstatus::all();
        $clientes = Clientes::where(function ($query) {
            $query->where('captado_por', Auth::id())
                ->orWhere('asignado_a', Auth::id());
        })->get();

        return view('admin.todos.edit', compact('tarea', 'clientes', 'tipos', 'estatuses'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'todo_tipo' => 'required',
            'fechaLimite' => 'required',
            'cliente_id' => 'required'
        ]);

        // dd($request);

        $tarea = new ToDo();
        $tarea->nombre = $request->nombre;
        $tarea->descripcion = $request->descripcion;
        $tarea->fechaLimite = str_replace('T', ' ', $request->fechaLimite);
        $tarea->user_id = Auth::user()->id;
        $tarea->todo_estatus = $request->todo_estatus;
        $tarea->todo_tipo = $request->todo_tipo;
        $tarea->cliente_id = $request->cliente_id;

        $tarea->save();

        return redirect('/admin/todo')->with('status', 'Tarea Creada Exitosamente!');
    }

    public function destroy($id)
    {
        $tarea = ToDo::where('id', $id)->first();

        $tarea->delete();

        return redirect('/admin/todo')->with('status', 'Tarea Eliminada!');
    }
}
