<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class MostrarPropiedades extends Component
{
    use WithPagination;

    public $criterio = '';

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'criterio' => ['except' => ''],
    ];

    public function updatedCriterio(): void
    {
        $this->resetPage();
    }

    public function clearSearch(): void
    {
        $this->criterio = '';
        $this->resetPage();
    }

    public function render()
    {
        $propiedades = DB::table('propiedads')
            ->select(
                'propiedads.id',
                'propiedads.referencia',
                'propiedads.aprobada',
                'propiedads.activa',
                'propiedads.foto_portada',
                'propiedads.provincia',
                'propiedads.ciudad',
                'propiedads.sector_id',
                'propiedads.barrio_id',
                'sectores.sector as sector_nombre',
                'barrios.barrio as barrio_nombre',
                'provincias.provincia as provincia_nombre',
                'tipos_de_propiedads.tipo as tipo_nombre',
                'disponible_paras.disponible_para as disponible_para_nombre',
                'propiedads.direccion',
                'propiedads.precio',
                'propiedads.titulo',
                'propiedads.habitaciones',
                'propiedads.banos',
                'propiedads.parqueos',
                'propiedads.metraje',
                'propiedads.asignada_a',
                'propiedads.tipo',
                'propiedads.disponible_para',
                'propiedads.Moneda',
                'propiedads.vendida',
                'propiedads.created_at'
            )
            ->leftJoin('provincias', 'propiedads.provincia', '=', 'provincias.id')
            ->leftJoin('sectores', 'propiedads.sector_id', '=', 'sectores.id')
            ->leftJoin('barrios', 'propiedads.barrio_id', '=', 'barrios.id')
            ->leftJoin('tipos_de_propiedads', 'propiedads.tipo', '=', 'tipos_de_propiedads.id')
            ->leftJoin('disponible_paras', 'propiedads.disponible_para', '=', 'disponible_paras.id');

        $searchTerm = trim((string) $this->criterio);

        if ($searchTerm !== '') {
            $criterio = '%' . $searchTerm . '%';
            $propiedades->where(function ($query) use ($criterio) {
                $query->where('titulo', 'like', $criterio)
                    ->orWhere('propiedads.referencia', 'like', $criterio)
                    ->orWhere('provincias.provincia', 'like', $criterio)
                    ->orWhere('propiedads.ciudad', 'like', $criterio)
                    ->orWhere('sectores.sector', 'like', $criterio)
                    ->orWhere('barrios.barrio', 'like', $criterio);
            });
        }

        $propiedades = $propiedades
            ->orderBy('propiedads.created_at', 'desc')
            ->paginate(20);

        return view('livewire.mostrar-propiedades', compact('propiedades'));
    }
}
