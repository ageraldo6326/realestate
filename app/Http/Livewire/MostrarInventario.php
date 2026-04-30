<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Propiedad;
use App\Services\CatalogoService;
use App\Services\InmobiliariaService;
use Livewire\WithPagination;

class MostrarInventario extends Component
{
    public $criterio;
    public $precio_inicial;
    public $precio_final;
    public $zona;
    public $moneda;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->moneda = 'RD$';
        $this->zona = "Seleccionar zona";
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function render()
    {
        $inmobiliaria = InmobiliariaService::get();

        $zonas = CatalogoService::zonas();
        $propiedades = Propiedad::query();
        $propiedades->select('propiedads.id', 'aprobada', 'foto_portada', 'provincia', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at');
        $propiedades->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id');
        $propiedades->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id');

        if ($this->criterio != "") {
            $criterio = $this->criterio;
            $propiedades->where(function ($query) use ($criterio) {
                $query->where('propiedads.id', '=', $criterio)
                    ->orWhere('propiedads.referencia', '=', $criterio);
            });
        }

        if ($this->zona != "Seleccionar zona") {
            $propiedades->where('zona_id', '=', $this->zona);
        }

        if ($this->precio_inicial != "" and $this->precio_final != "") {
            $propiedades->where('precio', '>=', str_replace(",", "", $this->precio_inicial));
            $propiedades->where('precio', '<=', str_replace(",", "", $this->precio_final));
        };

        $propiedades->where('activa', '=', 1);
        $propiedades->where('vendida', '=', 0);

        if ((bool) optional($inmobiliaria)->aprobacion) {
            $propiedades->where('aprobada', '=', 1);
        }

        $propiedades->where('moneda', '=', $this->moneda);
        $propiedades->orderBy('propiedads.created_at', 'desc');
        $propiedades =  $propiedades->paginate(5);


        return view('livewire.mostrar-inventario', compact("propiedades", "zonas"));
    }
}
