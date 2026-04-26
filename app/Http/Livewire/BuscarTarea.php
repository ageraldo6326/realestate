<?php

namespace App\Http\Livewire;

use App\Models\ToDoTipo;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class BuscarTarea extends Component
{   use WithPagination;
    use WithFileUploads;

    protected $listeners = ['borrarTarea'];
    protected $paginationTheme = 'bootstrap';

    public $Id=0, $criterio="", $tarea, $color;

    public function render()
    {
        $tareas = ToDoTipo::where('todo_tipo','like','%' . $this->criterio . '%')
        ->OrWhere('id','=', $this->criterio)
        ->orderby('id','desc')->paginate(5);

        return view('livewire.buscar-tarea',compact('tareas'));
    }

    public function updating(){
        $this->resetPage();
    }

    public function clear() {
        $this->criterio = "";
        $this->Id = 0;
        $this->tarea = "";
        $this->color = "";
    }

    public function edit($id) {
        $tarea = ToDoTipo::find($id);
        $this->tarea = $tarea->todo_tipo;
        $this->color = $tarea->color;
        $this->Id = $id;
    }

    public function borrarTarea($id) {
        $tarea = ToDoTipo::find($id);
        $tarea->delete();
    }

    public function store() {

        $this->validate([
            'tarea' => 'required',
        ]);

        $tarea = new ToDoTipo();
        $tarea->todo_tipo = $this->tarea;
        $tarea->color = $this->color;

        $tarea->save();

        session()->flash('status', 'Tarea guardada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }

    public function update($id) {
        $tarea = ToDoTipo::find($id);
        $tarea->todo_tipo = $this->tarea;
        $tarea->color = $this->color;

        $tarea->save();

        session()->flash('status', 'Tarea actualizada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }


}
