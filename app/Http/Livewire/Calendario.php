<?php

namespace App\Http\Livewire;

use App\Models\ToDo;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Calendario extends Component
{
    protected $listeners = ['status'];

    public function render()
    {
        $todo = ToDo::query();

        $todo->select('to_dos.id','to_dos.nombre','descripcion','fechaLimite','to_do_tipos.todo_tipo','to_do_estatuses.todo_estatus','user_id','cliente_id','to_do_tipos.color','clientes.nombre as cliente');
        $todo->leftJoin('to_do_estatuses','to_dos.todo_estatus','=','to_do_estatuses.id');
        $todo->leftJoin('to_do_tipos','to_dos.todo_tipo','=','to_do_tipos.id');
        $todo->leftJoin('clientes','to_dos.cliente_id','=','clientes.id');
        $todo->where('user_id','=',Auth::user()->id);  

        $tareas = $todo->get();
        return view('livewire.calendario', compact('tareas'));
    }
    
    public function estatus($id)
    {
        $todo = ToDo::find($id);

        session()->flash('status', $todo->descripcion);

    }
}