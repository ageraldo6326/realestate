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
use Livewire\WithPagination;
use App\Models\Disponible_para;
use App\Models\TiposDePropiedad;
use App\Http\Livewire\DisponiblePara;

class BuscarPropiedadesPorTipos extends Component
{    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $tipo_id, $tipo;

    public function mount($tipo_id, $tipo)
    {
        $this->tipo_id = $tipo_id;
        $this->tipo = $tipo;
    }
    public function render()
    {

        $inmobiliaria = Inmobiliaria::first();

        $portadas = Portada::all();

        $zonas = Zonas::all();

        $disponibles_para = Disponible_para::all();

        $tipos_propiedades = TiposDePropiedad::all();

        $testimonios = Testimonio::all();

        $enfoques = Enfoque::all();

        $posts = Post::all();

        $propiedades = Propiedad::query();

        $propiedades->select('propiedads.id', 'telefono', 'disponible_paras.disponible_para', 'foto_portada','slug','referencia', 'provincia','zona_id', 'zona', 'direccion', 'precio', 'propiedads.titulo', 'descripcion_corta', 'propiedads.descripcion', 'propiedads.metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_paras.disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'propiedads.metadescription', 'propiedads.created_at', 'propiedads.updated_at');
        $propiedades->where('activa','=',1);
        $propiedades->where('tipo', $this->tipo_id);

        if (optional($inmobiliaria)->aprobacion === 'on') {
            $propiedades->where('aprobada','=',1);
        }
        
        $propiedades->leftJoin('zonas','propiedads.zona_id','=','zonas.id');
        $propiedades->leftJoin('estados','propiedads.estado_id','=','estados.id');
        $propiedades->leftJoin('users', 'propiedads.asignada_a', '=', 'users.email');
        $propiedades->leftJoin('disponible_paras','propiedads.disponible_para','=','disponible_paras.id');
        $propiedades->orderBy('created_at','desc');

        $propiedades = $propiedades->paginate(20);  

        return view('livewire.buscar-propiedades-por-tipos',compact('propiedades','zonas', 'disponibles_para', 'tipos_propiedades'));
    }

}
