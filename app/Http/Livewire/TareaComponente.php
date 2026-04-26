<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ToDoTipo;
use App\Models\ToDoEstatus;
use App\Models\Clientes;
use App\Models\ToDo;
use Facade\Ignition\QueryRecorder\Query;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TareaComponente extends Component
{
    public $criterio = "";
    public $estatus = "";
    public $tipo = "";

    public $Id, $nombre, $descripcion, $fechaLimite, $todo_tipo, $todo_estatus, $user_id, $cliente_id, $created_at;

    use WithPagination;

    protected $rules = [
        'nombre' => 'required',
        'descripcion' => 'required',
        'fechaLimite'  => 'required',
        'todo_tipo' => 'required',
        'todo_estatus' => 'required',
        'cliente_id'  => 'required',
    ];

    public function render()
    {
        $todo = ToDo::query();

        $todo->select('to_dos.id', 'to_dos.nombre', 'descripcion', 'fechaLimite', 'to_do_tipos.todo_tipo', 'to_do_estatuses.todo_estatus', 'user_id', 'cliente_id', 'clientes.nombre as cliente');
        $todo->leftJoin('to_do_estatuses', 'to_dos.todo_estatus', '=', 'to_do_estatuses.id');
        $todo->leftJoin('to_do_tipos', 'to_dos.todo_tipo', '=', 'to_do_tipos.id');
        $todo->leftJoin('clientes', 'to_dos.cliente_id', '=', 'clientes.id');
        $todo->where('user_id', '=', Auth::user()->id);
        if ($this->criterio != "") {
            $todo->where('to_dos.nombre', 'like', "%$this->criterio%");
        }
        if ($this->tipo != "") {
            $todo->where('to_dos.todo_tipo', '=', "$this->tipo");
        }
        if ($this->estatus != "") {
            $todo->where('to_dos.todo_estatus', '=', "$this->estatus");
        }
        $todo->orderBy('fechaLimite', 'desc');

        $todos = $todo->paginate(30);


        $tipos = ToDoTipo::all();
        $estatuses = TodoEstatus::all();
        $clientes = Clientes::where(function ($query) {
            $query->where('captado_por', Auth::id())
                ->orWhere('asignado_a', Auth::id());
        })->get();

        return view('livewire.tarea-componente', compact('todos', 'tipos', 'clientes', 'estatuses'));
    }

    public function clear()
    {
        $this->Id = 0;
        $this->nombre = "";
        $this->fechaLimite = "";
        $this->todo_tipo = "";
        $this->todo_estatus = "";
        $this->user_id = "";
        $this->cliente_id = "";
        $this->descripcion = "";
        $this->resetValidation();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('close-modal-delete');
    }

    public function store()
    {

        $this->validate();
        $tarea = new ToDo();
        $tarea->nombre = $this->nombre;
        $tarea->descripcion = $this->descripcion;
        $tarea->fechaLimite = $this->fechaLimite;
        $tarea->todo_tipo = $this->todo_tipo;
        $tarea->todo_estatus = $this->todo_estatus;
        $tarea->user_id = Auth::user()->id;
        $tarea->cliente_id = $this->cliente_id;
        $tarea->save();
        $this->clear();
    }

    public function edit($id)
    {
        $tarea = Todo::find($id);
        $this->Id = $tarea->id;
        $this->nombre = $tarea->nombre;
        $this->descripcion = $tarea->descripcion;
        $this->fechaLimite = $tarea->fechaLimite;
        $this->todo_tipo = $tarea->todo_tipo;
        $this->todo_estatus = $tarea->todo_estatus;
        $this->cliente_id = $tarea->cliente_id;
    }

    public function update($id)
    {
        $tarea = Todo::find($id);
        $tarea->nombre = $this->nombre;
        $tarea->descripcion = $this->descripcion;
        $tarea->fechaLimite = $this->fechaLimite;
        $tarea->todo_tipo = $this->todo_tipo;
        $tarea->todo_estatus = $this->todo_estatus;
        $tarea->cliente_id = $this->cliente_id;
        $tarea->save();
        $this->clear();
    }

    public function delete($id)
    {
        $zona = Todo::find($id);
        $zona->delete();
        $this->clear();
    }
}
