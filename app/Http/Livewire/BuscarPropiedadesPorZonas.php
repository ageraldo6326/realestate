<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Propiedad;
use Livewire\WithPagination;
use App\Services\CatalogoService;
use App\Services\InmobiliariaService;

class BuscarPropiedadesPorZonas extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $zona_id, $zona;

    public function mount($zona_id, $zona)
    {
        $this->zona_id = $zona_id;
        $this->zona = $zona;
    }
    public function render()
    {

        $inmobiliaria = InmobiliariaService::get();

        $portadas = CatalogoService::portadas();

        $zonas = CatalogoService::zonas();

        $disponibles_para = CatalogoService::disponiblePara();

        $tipos_propiedades = CatalogoService::tipos();

        $testimonios = CatalogoService::testimonios();

        $enfoques = CatalogoService::enfoques();

        $posts = CatalogoService::posts();

        $propiedades = Propiedad::query();

        $propiedades->select('propiedads.id', 'telefono', 'disponible_paras.disponible_para', 'foto_portada', 'slug', 'referencia', 'provincia', 'zona_id', 'zona', 'direccion', 'precio', 'propiedads.titulo', 'descripcion_corta', 'propiedads.descripcion', 'propiedads.metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_paras.disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'propiedads.metadescription', 'propiedads.created_at', 'propiedads.updated_at');
        $propiedades->where('activa', '=', 1);
        $propiedades->where('zona_id', $this->zona_id);

        if ((bool) optional($inmobiliaria)->aprobacion) {
            $propiedades->where('aprobada', '=', 1);
        }

        $propiedades->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id');
        $propiedades->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id');
        $propiedades->leftJoin('users', 'propiedads.asignada_a_id', '=', 'users.id');
        $propiedades->leftJoin('disponible_paras', 'propiedads.disponible_para', '=', 'disponible_paras.id');
        $propiedades->whereNull('users.deleted_at');
        $propiedades->orderBy('propiedads.created_at', 'desc');

        $propiedades = $propiedades->paginate(20);

        return view('livewire.buscar-propiedades-por-zonas', compact('propiedades', 'zonas', 'disponibles_para', 'tipos_propiedades'));
    }
}
