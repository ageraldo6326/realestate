<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Venta;
use Livewire\WithPagination;

class RegistrarVentas extends Component
{
    use WithPagination;

    public $criterioPropiedad = "Angel";
    public $criterio;

    public $created_at, $id_propiedad, $refPropiedad, $tituloPropiedad, $tipoPropiedad, $zonaPropiedad, $estadoPropiedad,
    $fechaPropiedadCreada, $precio, $comision, $id_vendedor, $nombre_vendedor, $id_comprador, $nombre_comprador, $medio_comprador,
    $id_asesor, $nombre_asesor, $fechaVentaCierre, $Id;

    protected $paginationTheme = 'bootstrap';


    public function render()
    {
        $query = Venta::query();

        if ($this->criterio != "") {
            $query->where(function ($salesQuery) {
                $salesQuery->where('refPropiedad', '=', $this->criterio)
                    ->orWhere('tituloPropiedad', 'like', "%{$this->criterio}%")
                    ->orWhere('nombre_asesor', 'like', "%{$this->criterio}%")
                    ->orWhere('nombre_comprador', 'like', "%{$this->criterio}%");
            });
        }

        $query->orderBy('id', 'desc');

        $ventas = $query->paginate(25);

        return view('livewire.registrar-ventas', compact('ventas'));
    }

    public function updatingCriterio()
    {
        $this->resetPage();
    }

    public function clear2() {

    }
}
