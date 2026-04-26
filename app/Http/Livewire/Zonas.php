<?php

namespace App\Http\Livewire;

use App\Models\Zonas as ModelsZonas;
use Livewire\Component;
use Livewire\WithPagination;

class Zonas extends Component
{

    use WithPagination;

    public $formTitle = "Zonas";
    public $Id = 0, $zonaName, $criterio="";

    protected $rules = [
        'zonaName' => 'required',
    ];
    

    public function render()
    {
        if ($this->criterio=="") {
            $zonas = ModelsZonas::paginate(5);
        } else {
            $zonas = ModelsZonas::where('zona','like',"%$this->criterio%")->paginate(6);
        }

        return view('livewire.zonas',compact('zonas'));
    }

    public function clear() {
        $this->Id = 0;
        $this->zonaName = "";
        $this->resetValidation();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('close-modal-delete');
    }

    public function store() {

        $this->validate();

        $zona = New ModelsZonas();
        $zona->zona = $this->zonaName;
        $zona->save();
        $this->clear();
    }

    public function update($id) {

        $this->validate();

        $zona = ModelsZonas::find($id);
        $zona->zona = $this->zonaName;
        $zona->save();
        $this->clear();
    }    

    public function delete($id) {
        $zona = ModelsZonas::find($id);
        $zona->delete();
        $this->clear();

    }      


    public function edit($id) {
        $zona = ModelsZonas::find($id);
        $this->zonaName = $zona->zona;
        $this->Id = $zona->id;
    }    
}
