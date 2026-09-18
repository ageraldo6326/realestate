<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Propiedad;
use Livewire\WithPagination;
use App\Services\CatalogoService;
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
        $provincias = CatalogoService::provincias();
        // El catálogo completo contiene miles de sectores. No se incluye en el HTML
        // inicial: se carga cuando el visitante ha elegido una provincia.
        $sectores = filled($this->provincia_id_criterio)
            ? CatalogoService::sectores()
                ->where('provincia_id', $this->provincia_id_criterio)
                ->values()
            : collect();
        $tipos = CatalogoService::tipos();

        $propiedades = Propiedad::query()->publiclyVisible();

        $propiedades->select(
            'propiedads.id',
            'disponible_paras.disponible_para',
            'foto_portada',
            'slug',
            'referencia',
            'propiedads.ciudad',
            'sectores.sector as sector_nombre',
            'barrios.barrio as barrio_nombre',
            'provincias.provincia as provincia_nombre',
            'propiedads.precio',
            'propiedads.titulo',
            'propiedads.descripcion_corta',
            'propiedads.habitaciones',
            'propiedads.banos',
            'propiedads.metraje',
            'propiedads.Moneda',
            'propiedads.updated_at',
            DB::raw('COALESCE(assigned_user.name, creator_user.name) as asesor_nombre'),
            DB::raw('COALESCE(assigned_user.telefono, creator_user.telefono) as asesor_telefono'),
            DB::raw('COALESCE(assigned_user.foto, creator_user.foto) as asesor_foto')
        );

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

        $propiedades->leftJoin('provincias', 'propiedads.provincia', '=', 'provincias.id');
        $propiedades->leftJoin('sectores', 'propiedads.sector_id', '=', 'sectores.id');
        $propiedades->leftJoin('barrios', 'propiedads.barrio_id', '=', 'barrios.id');
        $propiedades->leftJoin('users as assigned_user', 'propiedads.asignada_a_id', '=', 'assigned_user.id');
        $propiedades->leftJoin('users as creator_user', 'propiedads.captada_por', '=', 'creator_user.id');
        $propiedades->leftJoin('disponible_paras', 'propiedads.disponible_para', '=', 'disponible_paras.id');
        $propiedades->whereNull('assigned_user.deleted_at');
        $propiedades->orderBy('propiedads.created_at', 'desc');

        $propiedades = $propiedades->paginate(3);

        return view('livewire.buscar-propiedades-home', compact('provincias', 'sectores', 'tipos', 'propiedades'));
    }
}
