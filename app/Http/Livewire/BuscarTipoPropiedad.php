<?php

namespace App\Http\Livewire;

use App\Models\TiposDePropiedad;
use Livewire\Component;
use Livewire\WithPagination;

class BuscarTipoPropiedad extends Component
{
    use WithPagination;

    public $criterio = '';

    protected $listeners = ['borrarTipoPropiedad'];

    public function render()
    {
        if ($this->criterio == '') {
            $tipoPropiedades = TiposDePropiedad::orderByDesc('id')->paginate(10);
        } else {
            $tipoPropiedades = TiposDePropiedad::where('tipo', 'like', "%{$this->criterio}%")
                ->orderByDesc('id')
                ->paginate(10);
        }

        return view('livewire.buscar-tipo-propiedad', compact('tipoPropiedades'));
    }

    public function updatingCriterio()
    {
        $this->resetPage();
    }

    public function limpiar()
    {
        $this->criterio = '';
        $this->resetPage();
    }

    public function borrarTipoPropiedad($id)
    {
        $tipoPropiedad = TiposDePropiedad::find($id);
        if ($tipoPropiedad) {
            $tipoPropiedad->delete();
            session()->flash('status', 'Tipo de propiedad eliminado exitosamente.');
        }
    }
}
