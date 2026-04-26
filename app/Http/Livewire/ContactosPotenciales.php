<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ContactosPotenciales extends Component
{
    public $periodo;
    public function render()
    {
        return view('livewire.contactos-potenciales');
    }
}
