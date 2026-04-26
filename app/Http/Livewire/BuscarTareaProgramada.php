<?php

namespace App\Http\Livewire;

use App\Models\ToDo;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\ToDoTipo;
use App\Models\ToDoEstatus;
use Livewire\WithPagination;
use Illuminate\Queue\Listener;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BuscarTareaProgramada extends Component
{
    public $criterio = "", $tipo = "", $estatus = "", $fecha_inicio = "", $fecha_fin = "";
    public $Id, $nombre, $descripcion, $fechaLimite, $todo_tipo, $todo_estatus, $user_id, $cliente_id, $created_at, $cliente_nombre;
    use WithPagination;

    protected $listeners = ['borrarTareaProgramada' => 'delete'];
    protected $paginationTheme = 'bootstrap';

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

        if ($this->fecha_inicio != "" && $this->fecha_fin != "") {
            $todo->where('fechaLimite', '>=', $this->fecha_inicio . ' 00:00:00');
            $todo->where('fechaLimite', '<=', $this->fecha_fin . ' 23:59:59');
        }
        $todo->orderBy('fechaLimite', 'desc');

        $tareas = $todo->paginate(5);

        $estatuses = ToDoEstatus::all();
        $tipos = ToDoTipo::all();

        $clientes = Clientes::where(function ($query) {
            $query->where('captado_por', Auth::id())
                ->orWhere('asignado_a', Auth::id());
        })->get();

        return view('livewire.buscar-tarea-programada', compact('tareas', 'estatuses', 'tipos', 'clientes'));
    }

    public function updatingcriterio()
    {
        $this->resetPage();
    }

    public function updatingtipo()
    {
        $this->resetPage();
    }

    public function updatingestatus()
    {
        $this->resetPage();
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
        $this->cliente_nombre = "";
        $this->resetValidation();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('close-modal-delete');
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

    public function verTarea($id)
    {
        $tarea = ToDo::query();

        $tarea->select('to_dos.id', 'to_dos.nombre', 'descripcion', 'fechaLimite', 'to_do_tipos.todo_tipo', 'to_do_estatuses.todo_estatus', 'user_id', 'cliente_id', 'clientes.nombre as cliente');
        $tarea->leftJoin('to_do_estatuses', 'to_dos.todo_estatus', '=', 'to_do_estatuses.id');
        $tarea->leftJoin('to_do_tipos', 'to_dos.todo_tipo', '=', 'to_do_tipos.id');
        $tarea->leftJoin('clientes', 'to_dos.cliente_id', '=', 'clientes.id');
        $tarea->where('to_dos.id', '=', $id);
        $tarea = $tarea->first();

        $this->Id = $tarea->id;
        $this->nombre = $tarea->nombre;
        $this->descripcion = $tarea->descripcion;
        $this->fechaLimite = $tarea->fechaLimite;
        $this->todo_tipo = $tarea->todo_tipo;
        $this->todo_estatus = $tarea->todo_estatus;
        $this->cliente_nombre = $tarea->cliente;
    }

    public function update($id)
    {

        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'fechaLimite' => 'required',
            'todo_estatus' => 'required',
            'todo_tipo' => 'required',
            'cliente_id' => 'required',
        ]);

        $tarea = Todo::find($id);
        $tarea->nombre = $this->nombre;
        $tarea->descripcion = $this->descripcion;
        $tarea->fechaLimite = $this->fechaLimite;
        $tarea->todo_tipo = $this->todo_tipo;
        $tarea->todo_estatus = $this->todo_estatus;
        $tarea->cliente_id = $this->cliente_id;
        $tarea->save();
        $this->clear();

        session()->flash('status', 'Tarea actualizada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }

    public function store()
    {

        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'fechaLimite' => 'required',
            'todo_estatus' => 'required',
            'todo_tipo' => 'required',
            'cliente_id' => 'required',
        ]);

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

        session()->flash('status', 'Tarea guardada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }

    public function delete($id)
    {
        $tarea = ToDo::find($id);
        $tarea->delete();

        session()->flash('status', 'Tarea eliminada exitosamente');
    }
}
