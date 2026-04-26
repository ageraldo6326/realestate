<?php

namespace App\Http\Livewire;

use App\Models\Portada;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;

class BuscarPortada extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $Id = 0, $criterio = "", $minititulo, $titulo, $descripcion, $foto, $enlace1, $url1, $enlace2, $url2, $video;

    protected $listeners = ['borrarPortada'];
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $portadas = Portada::where('titulo', 'like', '%' . $this->criterio . '%')
            ->OrWhere('id', '=', $this->criterio)
            ->orderby('id', 'desc')->paginate(5);

        return view('livewire.buscar-portada', compact('portadas'));
    }

    public function borrar_foto()
    {
        $this->foto = '';
    }

    public function updating()
    {
        $this->resetPage();
    }


    public function borrarPortada($id)
    {
        $portada = Portada::find($id);
        $portada->delete();
        $this->resetPage();
    }

    public function edit($id)
    {
        $portada = Portada::find($id);
        $this->minititulo = $portada->minititulo;
        $this->titulo = $portada->titulo;
        $this->descripcion = $portada->descripcion;
        $this->foto = $portada->foto;
        $this->enlace1 = $portada->enlace1;
        $this->url1 = $portada->url1;
        $this->enlace2 = $portada->enlace2;
        $this->url2 = $portada->url2;
        $this->video = $portada->video;
        $this->Id = $id;


        $this->emit('editarDescripcion', $portada->descripcion);
    }

    public function clear()
    {
        $this->minititulo = "";
        $this->titulo = "";
        $this->descripcion = "";
        $this->foto = "";
        $this->enlace1 = "";
        $this->url1 = "";
        $this->enlace2 = "";
        $this->url2 = "";
        $this->video = "";
        $this->Id = 0;

        $this->emit('limpiarDescripcion');
    }

    public function store()
    {

        $this->validate([
            'minititulo' => 'required',
            'titulo' => 'required',
        ]);

        $portada = new Portada();
        $portada->minititulo = $this->minititulo;
        $portada->titulo = $this->titulo;
        $portada->descripcion = $this->descripcion;
        $portada->enlace1 = $this->enlace1;
        $portada->url1 = $this->url1;
        $portada->enlace2 = $this->enlace2;
        $portada->url2 = $this->url2;
        $portada->video = $this->video;

        if ($this->foto != $portada->foto && $this->foto != '') {

            $fullPath = $this->foto->store('portada');
            $absolutePath = public_path('assets/' . $fullPath);
            if (!is_dir(dirname($absolutePath))) {
                mkdir(dirname($absolutePath), 0755, true);
            }
            Image::make($this->foto)->encode('webp', 90)->fit(1030, 655)->save($absolutePath);

            $portada->foto = $fullPath;
        } else {
            $portada->foto = $this->foto;
        }


        $portada->save();

        $this->clear();

        session()->flash('status', 'Portada guardada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }

    public function update($id)
    {

        $validated = $this->validate([
            'minititulo' => 'required',
            'titulo' => 'required',
        ]);

        $portada = Portada::where("id", $id)->first();
        $portada->minititulo = $this->minititulo;
        $portada->titulo = $this->titulo;
        $portada->descripcion = $this->descripcion;
        $portada->enlace1 = $this->enlace1;
        $portada->url1 = $this->url1;
        $portada->enlace2 = $this->enlace2;
        $portada->url2 = $this->url2;
        $portada->video = $this->video;


        if ($this->foto != $portada->foto and $this->foto != "") {

            $fullPath = $this->foto->store('portada');
            $absolutePath = public_path('assets/' . $fullPath);
            if (!is_dir(dirname($absolutePath))) {
                mkdir(dirname($absolutePath), 0755, true);
            }
            Image::make($this->foto)->encode('webp', 90)->fit(1030, 655)->save($absolutePath);

            $portada->foto = $fullPath;
        } else {
            $portada->foto = $this->foto;
        }

        $portada->save();

        session()->flash('status', 'Portada actualizada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }
}
