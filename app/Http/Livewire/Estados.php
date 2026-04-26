<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Estados as ModelsEstados;

class Estados extends Component
{

    use WithPagination;

    public $formTitle = "Estado";
    public $Id = 0, $estado, $criterio="";

    protected $rules = ['estado' => 'required',];
    protected $listeners = ["close-modal"];


    public function render()
    {
        if ($criterio="") {
            $estados = ModelsEstados::paginate(5);
        } else {
            $estados = ModelsEstados::where('estado','like',"%$this->criterio%")->paginate(6);
        }

        return view('livewire.estados',compact('estados'));
    }

    public function clear() {
        $this->Id = 0;
        $this->estado = "";
        $this->resetValidation();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function store() {
        $this->validate();
        $estado = New ModelsEstados();
        $estado->estado = $this->estado;
        $estado->save();
        $this->clear();
    }

    public function update($id) {
        $this->validate();
        $estado = ModelsEstados::find($id);
        $estado->estado = $this->estado;
        $estado->save();
        $this->clear();
    }    

    public function delete($id) {
        $estado = ModelsEstados::find($id);
        $estado->delete();
        $this->clear();
    }      


    public function edit($id) {
        $estado = ModelsEstados::find($id);
        $this->Id = $estado->id;
        $this->estado = $estado->estado;
    }        

}
