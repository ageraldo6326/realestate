<?php

namespace App\Http\Livewire;

use App\Models\Estados;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class BuscarEstado extends Component
{   use WithPagination;
    use WithFileUploads;

    protected $listeners = ['borrarEstado'];
    protected $paginationTheme = 'bootstrap';

    public $Id=0, $criterio="", $estado;
    public function render()
    {
        $estados = Estados::where('estado','like',"%$this->criterio%")
        ->OrWhere('id','=', $this->criterio)
        ->orderby('id','desc')->paginate(5);
        return view('livewire.buscar-estado',compact('estados'));
    }

    public function updating(){
        $this->resetPage();
    }

    public function clear() {
        $this->criterio = "";
        $this->Id = 0;
        $this->estado = "";
    }

    public function edit($id) {
        $estado = Estados::find($id);
        $this->estado = $estado->estado;
        $this->Id = $id;
    }

    public function borrarEstado($id) {
        $estado = Estados::find($id);
        $estado->delete();
    }

    public function store() {
        $estado = new Estados();
        $estado->estado = $this->estado;

        $estado->save();

        session()->flash('status', 'Estado guardada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }

    public function update($id) {
        $estado = Estados::find($id);
        $estado->estado = $this->estado;

        $estado->save();

        session()->flash('status', 'Estado actualizada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }
}
