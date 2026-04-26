<?php

namespace App\Http\Livewire;

use App\Models\TiposDePropiedad;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class BuscarTipoPropiedad extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $listeners = ['borrarTipoPropiedad'];
    protected $paginationTheme = 'bootstrap';

    public $Id=0, $criterio="", $tipo;
    public function render()
    {

        $tipoPropiedades = TiposDePropiedad::where('tipo','like',"%$this->criterio%")
        ->OrWhere('id','=', $this->criterio)
        ->orderby('id','desc')->paginate(5);
        return view('livewire.buscar-tipo-propiedad',compact('tipoPropiedades'));
    }

    public function updating(){
        $this->resetPage();
    }

    public function clear() {
        $this->criterio = "";
        $this->Id = 0;
        $this->tipo = "";
    }

    public function edit($id) {
        $tipoPropiedad = TiposDePropiedad::find($id);
        $this->tipo = $tipoPropiedad->tipo;
        $this->Id = $id;
    }

    public function borrarTipoPropiedad($id) {
        $tipoPropiedad = TiposDePropiedad::find($id);
        $tipoPropiedad->delete();
    }

    public function store() {
        $tipoPropiedad = new TiposDePropiedad();
        $tipoPropiedad->tipo = $this->tipo;

        $tipoPropiedad->save();

        session()->flash('status', 'Tipo de propiedad guardada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }

    public function update($id) {
        $tipoPropiedad = TiposDePropiedad::find($id);
        $tipoPropiedad->tipo = $this->tipo;

        $tipoPropiedad->save();

        session()->flash('status', 'Tipo de propiedad actualizada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }
}
