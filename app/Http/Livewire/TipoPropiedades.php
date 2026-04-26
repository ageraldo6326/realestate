<?php

namespace App\Http\Livewire;

use App\Models\TiposDePropiedad;
use Livewire\Component;
use Livewire\WithPagination;

class TipoPropiedades extends Component
{

    use WithPagination;

    public $formTitle = "Tipo Propiedades";
    public $Id = 0, $tipo, $criterio="";

    protected $rules = ['tipo' => 'required',];
    protected $listeners = ["close-modal"];


    public function render()
    {
        if ($criterio="") {
            $tipoPropiedades = TiposDePropiedad::paginate(5);
        } else {
            $tipoPropiedades = TiposDePropiedad::where('tipo','like',"%$this->criterio%")->paginate(5);
        }

        return view('livewire.tipo-propiedades',compact('tipoPropiedades'));
    }

    public function clear() {
        $this->Id = 0;
        $this->tipo = "";
        $this->dispatchBrowserEvent('close-modal');
        $this->resetValidation();
    }

    public function store() {
        $this->validate();

        $tipoPropiedad = New TiposDePropiedad();
        $tipoPropiedad->tipo = $this->tipo;
        $tipoPropiedad->save();
        $this->clear();
    }

    public function update($id) {
         $this->validate();
        $tipoPropiedad = TiposDePropiedad::find($id);
        $tipoPropiedad->tipo = $this->tipo;
        $tipoPropiedad->save();
        $this->clear();
    }    

    public function delete($id) {
        $tipoPropiedad = TiposDePropiedad::find($id);
        $tipoPropiedad->delete();
        $this->clear();
    }      


    public function edit($id) {
        $tipoPropiedad = TiposDePropiedad::find($id);
        $this->Id = $tipoPropiedad->id;
        $this->tipo = $tipoPropiedad->tipo;
    }        

}
