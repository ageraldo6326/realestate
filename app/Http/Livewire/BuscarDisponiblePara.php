<?php

namespace App\Http\Livewire;

use App\Models\Disponible_para;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class BuscarDisponiblePara extends Component
{   use WithPagination;
    use WithFileUploads;

    protected $listeners = ['borrarDisponiblePara'];
    protected $paginationTheme = 'bootstrap';

    public $Id=0, $criterio="", $disponible_para;
    public function render()
    {
        $disponiblespara = Disponible_para::where('disponible_para','like',"%$this->criterio%")
        ->OrWhere('id','=', $this->criterio)
        ->orderby('id','desc')->paginate(5);
        return view('livewire.buscar-disponible-para',compact('disponiblespara'));
    }

    public function updating(){
        $this->resetPage();
    }

    public function clear() {
        $this->criterio = "";
        $this->Id = 0;
        $this->disponible_para = "";

        $this->resetPage();
    }

    public function edit($id) {
        $disponible_para = Disponible_para::find($id);
        $this->disponible_para = $disponible_para->disponible_para;
        $this->Id = $id;
    }

    public function borrarDisponiblePara($id) {
        $disponible_para = Disponible_para::find($id);
        $disponible_para->delete();
    }

    public function store() {
        $disponible_para = new Disponible_para();
        $disponible_para->disponible_para = $this->disponible_para; 

        $disponible_para->save();

        session()->flash('status', 'Disponible para guardada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }

    public function update($id) {
        $disponible_para = Disponible_para::find($id);
        $disponible_para->disponible_para = $this->disponible_para;

        $disponible_para->save();

        session()->flash('status', 'Disponible para actualizada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }
}
