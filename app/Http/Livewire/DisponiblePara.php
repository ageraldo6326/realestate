<?php

namespace App\Http\Livewire;

use App\Models\Disponible_para;
use Livewire\Component;
use Livewire\WithPagination;

class DisponiblePara extends Component
{

    use WithPagination;

    public $formTitle = "Estado";
    public $Id = 0, $disponible_para, $criterio="";

    protected $rules = ['disponible_para' => 'required',];
    protected $listeners = ['close-modal'];


    public function render()
    {
        $disponiblespara = Disponible_para::query()
            ->when($this->criterio !== '', function ($query) {
                $query->where('disponible_para', 'like', '%' . $this->criterio . '%');
            })
            ->orderBy('disponible_para')
            ->paginate(12);

        return view('livewire.disponible-para',compact('disponiblespara'));
    }

    public function clear() {
        $this->Id = 0;
        $this->disponible_para = "";
        $this->resetValidation();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function store() {
        $this->validate();
        $disponiblespara = New Disponible_para();
        $disponiblespara->disponible_para = $this->disponible_para;
        $disponiblespara->save();
        $this->clear();
    }

    public function update($id) {
        $this->validate();
        $disponiblespara = Disponible_para::find($id);
        $disponiblespara->disponible_para = $this->disponible_para;
        $disponiblespara->save();
        $this->clear();
    }    

    public function delete($id) {
        $disponiblespara = Disponible_para::find($id);
        $disponiblespara->delete();
        $this->clear();
    }      


    public function edit($id) {
        $disponiblespara = Disponible_para::find($id);
        $this->Id = $disponiblespara->id;
        $this->disponible_para = $disponiblespara->disponible_para;
    }        

}
