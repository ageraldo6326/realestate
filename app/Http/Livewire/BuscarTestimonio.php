<?php

namespace App\Http\Livewire;

use App\Models\Testimonio;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;

class BuscarTestimonio extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $Id = 0, $criterio = "", $cliente, $testimonio, $cliente_foto, $activo;

    protected $listeners = ['borrarTestimonio'];
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $testimonios = Testimonio::where('cliente', 'like', '%' . $this->criterio . '%')
            ->OrWhere('id', '=', $this->criterio)
            ->orderby('id', 'desc')->paginate(5);
        return view('livewire.buscar-testimonio', compact('testimonios'));
    }

    public function borrar_foto()
    {
        $this->cliente_foto = "";
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function borrarTestimonio($id)
    {
        $testimonio = Testimonio::find($id);
        $testimonio->delete();
    }

    public function edit($id)
    {
        $testimonio = Testimonio::find($id);
        $this->cliente = $testimonio->cliente;
        $this->testimonio = $testimonio->testimonio;
        $this->cliente_foto = $testimonio->cliente_foto;
        $this->activo = $testimonio->activo;
        $this->Id = $id;

        $this->emit('editarTestimonio', $testimonio->testimonio);
    }

    public function clear()
    {
        $this->cliente = "";
        $this->testimonio = "";
        $this->cliente_foto = "";
        $this->activo = 0;
        $this->Id = 0;

        $this->emit('limpiarTestimonio');
    }


    public function store()
    {

        $validated = $this->validate([
            'cliente' => 'required',
            'testimonio' => 'required',
        ]);

        $testimonio = new Testimonio();
        $testimonio->cliente = $this->cliente;
        $testimonio->testimonio = $this->testimonio;

        if ($this->cliente_foto != $testimonio->cliente_foto and $this->cliente_foto != "") {

            $fullPath = $this->cliente_foto->store('testimonio');
            $absolutePath = public_path('assets/' . $fullPath);
            if (!is_dir(dirname($absolutePath))) {
                mkdir(dirname($absolutePath), 0755, true);
            }
            Image::make($this->cliente_foto)->encode('webp', 90)->fit(50, 50)->save($absolutePath);

            $testimonio->cliente_foto = $fullPath;
        } else {
            $testimonio->cliente_foto = $this->cliente_foto;
        }

        $testimonio->save();

        $this->clear();

        session()->flash('status', 'Testimonio guardada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }

    public function update($id)
    {

        $validated = $this->validate([
            'cliente' => 'required',
            'testimonio' => 'required',
        ]);

        $testimonio = Testimonio::where("id", $id)->first();
        $testimonio->cliente = $this->cliente;
        $testimonio->testimonio = $this->testimonio;


        if ($this->cliente_foto != $testimonio->cliente_foto and $this->cliente_foto != "") {

            $fullPath = $this->cliente_foto->store('testimonio');
            $absolutePath = public_path('assets/' . $fullPath);
            if (!is_dir(dirname($absolutePath))) {
                mkdir(dirname($absolutePath), 0755, true);
            }
            Image::make($this->cliente_foto)->encode('webp', 90)->fit(50, 50)->save($absolutePath);

            $testimonio->cliente_foto = $fullPath;
        } else {
            $testimonio->cliente_foto = $this->cliente_foto;
        }

        $testimonio->save();

        session()->flash('status', 'Testimonio actualizada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }
}
