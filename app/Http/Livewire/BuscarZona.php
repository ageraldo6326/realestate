<?php

namespace App\Http\Livewire;

use App\Models\Zonas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class BuscarZona extends Component
{

    use WithPagination;
    use WithFileUploads;

    protected $listeners = ['borrarZona'];
    protected $paginationTheme = 'bootstrap';

    public $Id=0, $criterio="", $zona;
    public function render()
    {

        $zonas = Zonas::where('zona','like',"%$this->criterio%")
        ->OrWhere('id','=', $this->criterio)
        ->orderby('id','desc')->paginate(6);

        return view('livewire.buscar-zona',compact('zonas'));
    }

    public function updating(){
        $this->resetPage();
    }


    public function borrarZona($id) {
        $zona = Zonas::find($id);
        $zona->delete();
    }    

    public function edit($id) {
        $zona = Zonas::find($id);
        $this->zona = $zona->zona;
        $this->Id = $id;
    }

    public function clear() {
        $this->zona = "";
        $this->Id = 0;        
    }

    public function store() {
        $zona = new Zonas();
        $zona->zona = $this->zona;

        $zona->save();

        session()->flash('status', 'Zona guardada exitosamente');

        $this->dispatchBrowserEvent('close-modal'); 

        
    }

    public function update($id) {
        $zona = Zonas::find($id);
        $zona->zona = $this->zona;

        $zona->save();

        session()->flash('status', 'Zona actualizada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
        
    }

}
