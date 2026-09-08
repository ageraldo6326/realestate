<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Propiedad;
use Livewire\WithPagination;
use App\Services\CatalogoService;
use App\Services\InmobiliariaService;
use Illuminate\Support\Facades\DB;

class BuscarPropiedadesHome extends Component
{
    public $titulo_criterio = '';
    public $provincia_id_criterio = '';
    public $sector_barrio_criterio = '';
    public $tipo_id_criterio = '';
    public $precio_inicial = '';
    public $precio_final = '';

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function updatingTituloCriterio(): void
    {
        $this->resetPage();
    }

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
        $tipos = CatalogoService::tipos();
        $disponibles_para = CatalogoService::disponiblePara();
        $testimonios = CatalogoService::testimonios();
        $enfoques = CatalogoService::enfoques();
        $posts = CatalogoService::posts();

        $propiedades = Propiedad::query();

        $propiedades->select(
            'propiedads.id',
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
            'propiedads.updated_at',
            DB::raw('COALESCE(assigned_user.name, creator_user.name) as asesor_nombre'),
            DB::raw('COALESCE(assigned_user.telefono, creator_user.telefono) as asesor_telefono'),
            DB::raw('COALESCE(assigned_user.foto, creator_user.foto) as asesor_foto')
        );

        $propiedades->where('activa', '=', 1);

        if (filled($this->titulo_criterio)) {
            $propiedades->where('propiedads.titulo', 'like', '%' . trim($this->titulo_criterio) . '%');
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

        if ((bool) optional($inmobiliaria)->aprobacion) {
            $propiedades->where('aprobada', '=', 1);
        }

        $propiedades->leftJoin('provincias', 'propiedads.provincia', '=', 'provincias.id');
        $propiedades->leftJoin('sectores', 'propiedads.sector_id', '=', 'sectores.id');
        $propiedades->leftJoin('barrios', 'propiedads.barrio_id', '=', 'barrios.id');
        $propiedades->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id');
        $propiedades->leftJoin('users as assigned_user', 'propiedads.asignada_a_id', '=', 'assigned_user.id');
        $propiedades->leftJoin('users as creator_user', 'propiedads.captada_por', '=', 'creator_user.id');
        $propiedades->leftJoin('disponible_paras', 'propiedads.disponible_para', '=', 'disponible_paras.id');
        $propiedades->whereNull('assigned_user.deleted_at');
        $propiedades->orderBy('propiedads.created_at', 'desc');

        $propiedades = $propiedades->paginate(3);

        return view('livewire.buscar-propiedades-home', compact('portadas', 'provincias', 'sectores', 'disponibles_para', 'tipos', 'propiedades', 'testimonios', 'inmobiliaria', 'enfoques', 'posts'));
    }
}
