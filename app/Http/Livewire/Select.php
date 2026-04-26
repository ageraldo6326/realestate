<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Select extends Component
{
    public $criterio;
    public function render()
    {
        return view('livewire.select');
    }
}
