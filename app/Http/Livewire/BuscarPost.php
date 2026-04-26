<?php

namespace App\Http\Livewire;

use finfo;
use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class BuscarPost extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $Id = 0, $criterio = "", $titulo, $contenido, $foto, $metadescription, $activo, $slug, $autor;
    public $open = false;

    protected $listeners = ['borrarPost'];
    protected $paginationTheme = 'bootstrap';


    public function render()
    {
        $posts = Post::where('titulo', 'like', '%' . $this->criterio . '%')
            ->OrWhere('id', '=', $this->criterio)
            ->orderby('id', 'desc')->paginate(5);
        return view('livewire.buscar-post', compact('posts'));
    }

    public function borrar_foto()
    {
        $this->foto = '';
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function borrarPost($id)
    {
        $post = Post::find($id);
        $post->delete();
    }

    public function clear()
    {
        $this->Id = 0;
        $this->titulo = "";
        $this->slug = "";
        $this->contenido = "";
        $this->metadescription = "";
        $this->autor = "";
        $this->foto = "";
        $this->activo = 0;

        $this->emit('limpiarContenido');
    }

    public function store()
    {
        $this->validate([
            'titulo' => 'required',
            'contenido' => 'required',
            'metadescription' => 'required'
        ]);

        $post = new Post();

        $post->titulo = $this->titulo;
        $post->slug = Str::slug($this->titulo);
        $post->contenido = $this->contenido;
        $post->metadescription = $this->metadescription;
        $post->autor = Auth::user()->name;
        $post->activo = $this->activo;


        if ($this->foto != $post->foto && $this->foto != null) {

            $fullPath = $this->foto->store('post');
            $absolutePath = public_path('assets/' . $fullPath);
            if (!is_dir(dirname($absolutePath))) {
                mkdir(dirname($absolutePath), 0755, true);
            }
            Image::make($this->foto)->encode('webp', 90)->fit(850, 650)->save($absolutePath);

            $post->foto = $fullPath;
        } else {

            $post->foto = $this->foto;
        }

        $post->save();

        $this->clear();

        session()->flash('status', 'Post guardado exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $this->Id = $id;
        $post = Post::find($id);
        $this->Id = $id;
        $this->titulo = $post->titulo;
        $this->slug = $post->slug;
        $this->contenido = $post->contenido;


        $this->metadescription = $post->metadescription;
        $this->autor = $post->autor;
        $this->foto = $post->foto;
        $this->activo = $post->activo;

        $this->emit('editarContenido', $post->contenido);
    }

    public function update($id)
    {
        $this->validate([
            'titulo' => 'required',
            'contenido' => 'required',
            'metadescription' => 'required'
        ]);

        $post = Post::find($id);

        $post->titulo = $this->titulo;
        $post->slug = Str::slug($this->titulo);
        $post->contenido = $this->contenido;
        $post->metadescription = $this->metadescription;
        $post->activo = $this->activo;


        if ($this->foto != $post->foto && $this->foto != null) {

            $fullPath = $this->foto->store('post');
            $absolutePath = public_path('assets/' . $fullPath);
            if (!is_dir(dirname($absolutePath))) {
                mkdir(dirname($absolutePath), 0755, true);
            }
            Image::make($this->foto)->encode('webp', 90)->fit(850, 650)->save($absolutePath);

            $post->foto = $fullPath;
        } else {

            $post->foto = $this->foto;
        }

        $post->save();

        $this->clear();

        session()->flash('status', 'Post actualizado exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }
}
