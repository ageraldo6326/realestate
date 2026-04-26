<?php

namespace App\Http\Livewire;

use App\Models\Enfoque;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;

class BuscarEnfoque extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $Id = 0, $criterio = "", $titulo, $enfoque, $foto;

    protected $listeners = ['borrarEnfoque'];
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $enfoques = Enfoque::where('titulo', 'like', '%' . $this->criterio . '%')
            ->OrWhere('id', '=', $this->criterio)
            ->orderby('id', 'desc')->paginate(5);
        return view('livewire.buscar-enfoque', compact('enfoques'));
    }

    public function borrar_foto()
    {
        $this->foto = '';
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function borrarEnfoque($id)
    {
        $enfoque = Enfoque::find($id);
        $enfoque->delete();
    }

    public function clear()
    {
        $this->Id = 0;
        $this->titulo = "";
        $this->enfoque = "";
        $this->foto = "";

        $this->emit('limpiarEnfoque');
    }

    public function edit($id)
    {
        $this->Id = $id;
        $enfoque = Enfoque::find($id);
        $this->titulo = $enfoque->titulo;
        $this->enfoque = $enfoque->enfoque;
        $this->foto = $enfoque->foto;
        $this->Id = $id;

        $this->emit('editarEnfoque', $enfoque->enfoque);
    }

    public function update($id)
    {
        $this->validate([
            'titulo' => 'required',
            'enfoque' => 'required',
        ]);

        $enfoque = Enfoque::find($id);

        $enfoque->titulo = $this->titulo;
        $enfoque->enfoque = $this->enfoque;


        if ($this->foto != $enfoque->foto and $this->foto != '') {

            $fullPath = $this->foto->store('enfoque');
            $absolutePath = public_path('assets/' . $fullPath);
            if (!is_dir(dirname($absolutePath))) {
                mkdir(dirname($absolutePath), 0755, true);
            }
            Image::make($this->foto)->encode('webp', 90)->fit(308, 400)->save($absolutePath);

            $enfoque->foto = $fullPath;
        } else {

            $enfoque->foto = $this->foto;
        }

        $enfoque->save();

        $this->clear();

        session()->flash('status', 'Enfoque actualizado exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }


    public function store()
    {
        $this->validate([
            'titulo' => 'required',
            'enfoque' => 'required',
        ]);

        $enfoque = new Enfoque();

        $enfoque->titulo = $this->titulo;
        $enfoque->enfoque = $this->enfoque;


        if ($this->foto != $enfoque->foto and $this->foto != '') {

            $fullPath = $this->foto->store('enfoque');
            $absolutePath = public_path('assets/' . $fullPath);
            if (!is_dir(dirname($absolutePath))) {
                mkdir(dirname($absolutePath), 0755, true);
            }
            Image::make($this->foto)->encode('webp', 90)->fit(308, 400)->save($absolutePath);

            $enfoque->foto = $fullPath;
        } else {

            $enfoque->foto = $this->foto;
        }

        $enfoque->save();

        $this->clear();

        session()->flash('status', 'Enforque guardado exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }
}
