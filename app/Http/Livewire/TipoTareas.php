<?php

namespace App\Http\Livewire;

use App\Models\ToDoTipo;
use Livewire\Component;
use Livewire\WithPagination;

class TipoTareas extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $formTitle = "Estado";
    public $Id = 0, $todo_tipo, $color, $criterio="";

    protected $rules = ['todo_tipo' => 'required', 'color' => 'required',];
    protected $listeners = ['close-modal'];

    public function render()
    {
        $tipostareas = ToDoTipo::query()
            ->when($this->criterio !== '', function ($query) {
                $query->where('todo_tipo', 'like', "%{$this->criterio}%")
                    ->orWhere('id', $this->criterio);
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.tipo-tareas', compact('tipostareas'));
    }

    public function updatingCriterio()
    {
        $this->resetPage();
    }

    public function clear() {
        $this->Id = 0;
        $this->todo_tipo = "";
        $this->color = "";
        $this->resetValidation();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function store() {
        $this->validate();
        $tipostareas = New ToDoTipo();
        $tipostareas->todo_tipo = $this->todo_tipo;
        $tipostareas->color = $this->color;
        $tipostareas->save();
        $this->clear();
    }

    public function update($id) {
        $this->validate();
        $tipostareas = ToDoTipo::find($id);
        $tipostareas->todo_tipo = $this->todo_tipo;
        $tipostareas->color = $this->color;
        $tipostareas->save();
        $this->clear();
    }    

    public function delete($id) {
        $tipostareas = ToDoTipo::find($id);
        $tipostareas->delete();
        $this->clear();
    }      


    public function edit($id) {
        $tipostareas = ToDoTipo::find($id);
        $this->Id = $tipostareas->id;
        $this->todo_tipo = $tipostareas->todo_tipo;
        $this->color = $tipostareas->color;

    }        

}
