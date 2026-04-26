<?php

namespace App\Http\Livewire;

use App\Models\Inmobiliaria;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class BuscarInmobiliaria extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $Id=0, $criterio="", $nombre, $correo, $direccion, $telefono, $titulo, $metadescription, $facebook, $instagram,
    $tiktok, $whatsapp, $quienessomos, $logo, $aprobacion, $favicon, $dominio, $slogan, $palabrasclaves;

    public function render()
    {
        $inmobiliarias = Inmobiliaria::paginate(5);

        return view('livewire.buscar-inmobiliaria',compact('inmobiliarias'));
    }

    public function clear() {
        $this->reset();

        $this->emit('limpiarQuienessomos');
    }

    public function edit($id) {
        $inmobiliaria = Inmobiliaria::find($id);
        $this->Id = $inmobiliaria->id;
        $this->nombre = $inmobiliaria->nombre;
        $this->correo = $inmobiliaria->correo;
        $this->direccion = $inmobiliaria->direccion;
        $this->telefono = $inmobiliaria->telefono;
        $this->titulo = $inmobiliaria->titulo;
        $this->metadescription = $inmobiliaria->metadescription;
        $this->facebook = $inmobiliaria->facebook;
        $this->instagram = $inmobiliaria->instagram;
        $this->tiktok = $inmobiliaria->tiktok;
        $this->whatsapp = $inmobiliaria->whatsapp;
        $this->quienessomos = $inmobiliaria->quienessomos;
        $this->logo = $inmobiliaria->logo;
        $this->favicon = $inmobiliaria->favicon;
        $this->slogan = $inmobiliaria->slogan;
        $this->palabrasclaves = $inmobiliaria->palabrasclaves;

        if ($inmobiliaria->aprobacion == 1) {
            $this->aprobacion = true;
        } else {
            $this->aprobacion = false;
        }
        
        $this->aprobacion = $inmobiliaria->aprobacion;
        $this->dominio = $inmobiliaria->dominio;

        $this->emit('editarQuienesSomos', $inmobiliaria->quienessomos);
    }

    public function borrar_favicon() {

        $this->favicon = '';
    }
    public function borrar_logo() {

        $this->logo = '';
    }


    public function update($id) {
        $inmobiliaria = Inmobiliaria::find($id);
        $inmobiliaria->nombre = $this->nombre;
        $inmobiliaria->correo = $this->correo;
        $inmobiliaria->direccion = $this->direccion;
        $inmobiliaria->telefono = $this->telefono;
        $inmobiliaria->titulo = $this->titulo;
        $inmobiliaria->metadescription = $this->metadescription;
        $inmobiliaria->facebook = $this->facebook;
        $inmobiliaria->instagram = $this->instagram;
        $inmobiliaria->tiktok = $this->tiktok;
        $inmobiliaria->whatsapp = $this->whatsapp;
        $inmobiliaria->quienessomos = $this->quienessomos;
        $inmobiliaria->aprobacion = $this->aprobacion;
        $inmobiliaria->dominio = $this->dominio;
        $inmobiliaria->slogan = $this->slogan;
        $inmobiliaria->palabrasclaves = $this->palabrasclaves;

        if ($this->logo != $inmobiliaria->logo && $this->logo != '') {

            $fullPath = $this->logo->store('inmobiliaria');
            
            $inmobiliaria->logo = $fullPath;

        } else {

            $inmobiliaria->logo = $this->logo;
        }  
        


        if ($this->favicon != $inmobiliaria->favicon && $this->favicon != '') {

            $fullPath = $this->favicon->store('inmobiliaria');
            
            $inmobiliaria->favicon = $fullPath;

        } else {

            $inmobiliaria->favicon = $this->favicon;
        }     

        $inmobiliaria->save();
        
        session()->flash('status', 'Inmobiliaria actualizada exitosamente');

        $this->dispatchBrowserEvent('close-modal');         
    }
}
