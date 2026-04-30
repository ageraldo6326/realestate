<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Propiedad;
use App\Services\CatalogoService;
use Livewire\WithPagination;
use App\Services\InmobiliariaService;

class BuscarPropiedadesPropiedades extends Component
{
    public $provincia_id_criterio = "", $sector_barrio_criterio = "", $tipo_id_criterio = "", $precio_inicial = "", $precio_final = "";

    use WithPagination;

    protected $queryString = [
        'provincia_id_criterio' => ['except' => '', 'as' => 'provincia_id'],
        'sector_barrio_criterio' => ['except' => '', 'as' => 'sector_id'],
        'tipo_id_criterio' => ['except' => '', 'as' => 'tipo_id'],
        'precio_inicial'   => ['except' => ''],
        'precio_final'     => ['except' => ''],
    ];

    public function mount()
    {
        $this->provincia_id_criterio = request()->get('provincia_id', '');
        $this->sector_barrio_criterio = request()->get('sector_id', request()->get('sector_barrio', ''));
        $this->tipo_id_criterio = request()->get('tipo_id', '');
    }

    protected $paginationTheme = 'bootstrap';

    public function updatingProvinciaIdCriterio()
    {
        $this->sector_barrio_criterio = '';
        $this->resetPage();
    }

    public function updatingSectorBarrioCriterio()
    {
        $this->resetPage();
    }

    public function updatingTipoIdCriterio()
    {
        $this->resetPage();
    }

    public function updatingPrecioInicial()
    {
        $this->resetPage();
    }

    public function updatingPrecioFinal()
    {
        $this->resetPage();
    }

    public function render()
    {
        $inmobiliaria = InmobiliariaService::get();

        $portadas = CatalogoService::portadas();
        $provincias = CatalogoService::provincias();
        $sectores = CatalogoService::sectores()
            ->when(filled($this->provincia_id_criterio), fn($col) => $col->where('provincia_id', $this->provincia_id_criterio));
        $disponibles_para = CatalogoService::disponiblePara();
        $tipos = CatalogoService::tipos();
        $testimonios = CatalogoService::testimonios();
        $enfoques = CatalogoService::enfoques();
        $posts = CatalogoService::posts();

        $propiedades = Propiedad::query();

        $propiedades->select(
            'propiedads.id',
            'telefono',
            'disponible_paras.disponible_para',
            'foto_portada',
            'slug',
            'referencia',
            'propiedads.provincia',
            'propiedads.ciudad',
            'propiedads.sector_id',
            'propiedads.barrio_id',
            'sectores.sector as sector_nombre',
            'barrios.barrio as barrio_nombre',
            'provincias.provincia as provincia_nombre',
            'direccion',
            'precio',
            'propiedads.titulo',
            'descripcion_corta',
            'propiedads.descripcion',
            'propiedads.metadescripcion',
            'habitaciones',
            'banos',
            'parqueos',
            'metraje',
            'metraje_construccion',
            'asignada_a',
            'captada_por',
            'tipo',
            'foto_vendedor',
            'disponible_paras.disponible_para',
            'destacada',
            'foto1',
            'foto2',
            'foto3',
            'foto4',
            'foto5',
            'foto6',
            'foto7',
            'foto8',
            'video1',
            'video2',
            'video3',
            'video4',
            'Moneda',
            'vendida',
            'lobby',
            'plantaelectrica',
            'camaravigilancia',
            'escaleraemergencia',
            'maderapreciosa',
            'balcon',
            'walkincloset',
            'jacuzzi',
            'areainfantil',
            'banovisitas',
            'cisterna',
            'inversorareacomun',
            'gascomun',
            'gazebo',
            'pozo',
            'piscina',
            'familyroom',
            'cuartodeservicio',
            'patio',
            'portonelectrico',
            'seguridad24horas',
            'ascensor',
            'parqueostechados',
            'preinstalacionairetinacoinversor',
            'terraza',
            'estudio',
            'gimnasio',
            'controldeacceso',
            'clicks',
            'propiedads.metadescription',
            'propiedads.created_at',
            'propiedads.updated_at'
        );

        $propiedades->where('activa', '=', 1);
        if ((bool) optional($inmobiliaria)->aprobacion) {
            $propiedades->where('aprobada', 1);
        }

        if (filled($this->provincia_id_criterio)) {
            $propiedades->where('propiedads.provincia', $this->provincia_id_criterio);
        }

        if (filled($this->sector_barrio_criterio)) {
            $propiedades->where('propiedads.sector_id', $this->sector_barrio_criterio);
        }

        if (filled($this->tipo_id_criterio)) {
            $propiedades->where('tipo', $this->tipo_id_criterio);
        }

        if (filled($this->precio_inicial) && filled($this->precio_final)) {
            $propiedades->whereBetween('precio', [str_replace(',', '', $this->precio_inicial), str_replace(',', '', $this->precio_final)]);
        }

        $propiedades->leftJoin('provincias', 'propiedads.provincia', '=', 'provincias.id');
        $propiedades->leftJoin('sectores', 'propiedads.sector_id', '=', 'sectores.id');
        $propiedades->leftJoin('barrios', 'propiedads.barrio_id', '=', 'barrios.id');
        $propiedades->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id');
        $propiedades->leftJoin('users', 'propiedads.asignada_a_id', '=', 'users.id');
        $propiedades->leftJoin('disponible_paras', 'propiedads.disponible_para', '=', 'disponible_paras.id');
        $propiedades->whereNull('users.deleted_at');
        $propiedades->orderBy('propiedads.created_at', 'desc');

        $propiedades = $propiedades->paginate(6);

        return view('livewire.buscar-propiedades-propiedades', compact('portadas', 'provincias', 'sectores', 'disponibles_para', 'tipos', 'propiedades', 'testimonios', 'inmobiliaria', 'enfoques', 'posts'));
    }
}
