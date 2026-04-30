<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class MostrarPropiedades extends Component
{
    public $criterio;

    use WithPagination;

    public function render()
    {
        $propiedades = DB::table('propiedads')
            ->select(
                'propiedads.id',
                'aprobada',
                'foto_portada',
                'propiedads.provincia',
                'propiedads.ciudad',
                'propiedads.sector_id',
                'propiedads.barrio_id',
                'sectores.sector as sector_nombre',
                'barrios.barrio as barrio_nombre',
                'provincias.provincia as provincia_nombre',
                'direccion',
                'precio',
                'titulo',
                'descripcion_corta',
                'descripcion',
                'metadescripcion',
                'habitaciones',
                'banos',
                'parqueos',
                'metraje',
                'metraje_construccion',
                'asignada_a',
                'captada_por',
                'tipo',
                'foto_vendedor',
                'disponible_para',
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
                'clicks',
                'metadescription',
                'propiedads.created_at',
                'propiedads.updated_at'
            )
            ->leftJoin('provincias', 'propiedads.provincia', '=', 'provincias.id')
            ->leftJoin('sectores', 'propiedads.sector_id', '=', 'sectores.id')
            ->leftJoin('barrios', 'propiedads.barrio_id', '=', 'barrios.id')
            ->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id');

        if ($this->criterio !== '') {
            $criterio = '%' . trim($this->criterio) . '%';
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
