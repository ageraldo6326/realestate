<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\Zonas;
use App\Models\Enfoque;
use App\Models\Portada;
use Livewire\Component;
use App\Models\Propiedad;
use App\Models\Testimonio;
use App\Models\Inmobiliaria;
use App\Models\Disponible_para;
use App\Models\TiposDePropiedad;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class BuscarPropiedadesHome extends Component
{

    public $zona_id_criterio = "", $tipo_id_criterio = "" , $precio_inicial = "", $precio_final = "";

    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public function updatingZonaIdCriterio(){
        $this->resetPage();
    }

    public function updatingTipoIdCriterio(){
        $this->resetPage();
    }

    public function updatingPrecioInicial(){
        $this->resetPage();
    }

    public function updatingPrecioFinal(){
        $this->resetPage();
    }

    public function render()
    {

        $inmobiliaria = Inmobiliaria::first();

        $portadas = Portada::all();

        $zonas = Zonas::all();

        $tipos = TiposDePropiedad::all();

        $disponibles_para = Disponible_para::all();

        $testimonios = Testimonio::all();

        $enfoques = Enfoque::all();

        $posts = Post::all();

        $propiedades = Propiedad::query();

        $propiedades->select('propiedads.id', 'telefono', 'disponible_paras.disponible_para', 'foto_portada','slug','referencia', 'provincia','zona_id', 'zona', 'direccion', 'precio', 'propiedads.titulo', 'descripcion_corta', 'propiedads.descripcion', 'propiedads.metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_paras.disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'propiedads.metadescription', 'propiedads.created_at', 'propiedads.updated_at');
        $propiedades->where('activa','=',1);

        if ($this->zona_id_criterio!='') {
            $propiedades->where('zona_id',$this->zona_id_criterio);
        }

        if ($this->tipo_id_criterio!='') {
            $propiedades->where('tipo',$this->tipo_id_criterio);
        }

        if ($this->precio_inicial!='' && $this->precio_final!='') { 
            $propiedades->whereBetween('precio', [ str_replace(',', '', $this->precio_inicial),  str_replace(',', '', $this->precio_final)]);
        }

        // if ($this->criterio!='') {
        //     $propiedades->where(function($query) use ($name){
        //         $query->orwhere('propiedads.titulo',"like","%$this->criterio%");
        //         $query->orwhere('propiedads.referencia',$this->criterio);
        //         $query->orwhere('zona','like',"%$this->criterio%");
        //     });
        // }

        if (optional($inmobiliaria)->aprobacion === 'on') {
            $propiedades->where('aprobada','=',1);
        }
        
        $propiedades->leftJoin('zonas','propiedads.zona_id','=','zonas.id');
        $propiedades->leftJoin('estados','propiedads.estado_id','=','estados.id');
        $propiedades->leftJoin('users', 'propiedads.asignada_a', '=', 'users.email');
        $propiedades->leftJoin('disponible_paras','propiedads.disponible_para','=','disponible_paras.id');
        $propiedades->orderBy('created_at','desc');

        $propiedades = $propiedades->paginate(3);

        return view('livewire.buscar-propiedades-home', compact('portadas', 'zonas', 'disponibles_para', 'tipos', 'propiedades', 'testimonios', 'inmobiliaria', 'enfoques', 'posts'));
    }
}
