<?php

namespace App\Http\Livewire;

use App\Models\Propiedad;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class MostrarPropiedadesPendientesPorAprobar extends Component
{
    use WithPagination;

    public $criterio = '';
    public $estado = 'todos';

    protected $queryString = [
        'criterio' => ['except' => ''],
        'estado' => ['except' => 'todos'],
    ];

    public function mount(): void
    {
        abort_unless(Gate::allows('access-admin'), 403);
    }

    public function updatedCriterio(): void
    {
        $this->resetPage();
    }

    public function updatedEstado(): void
    {
        $this->resetPage();
    }

    public function setEstado(string $estado): void
    {
        if (!in_array($estado, ['todos', 'pendientes', 'aprobadas'], true)) {
            return;
        }

        $this->estado = $estado;
    }

    public function clearFilters(): void
    {
        $this->criterio = '';
        $this->estado = 'todos';
        $this->resetPage();
    }

    public function render()
    {
        $baseQuery = Propiedad::query()
            ->select(['id', 'referencia', 'foto_portada', 'titulo', 'direccion', 'precio', 'Moneda', 'aprobada', 'activa', 'clicks', 'zona_id', 'captada_por', 'created_at'])
            ->with(['zona:id,zona', 'captador:id,name,email'])
            ->latest();

        $total = (clone $baseQuery)->count();
        $pendientes = (clone $baseQuery)->where('aprobada', false)->count();
        $aprobadas = $total - $pendientes;
        $propiedades = $this->applyFilters($baseQuery)->paginate(12);

        return view('livewire.mostrar-propiedades-pendientes-por-aprobar', compact('propiedades', 'total', 'pendientes', 'aprobadas'));
    }

    private function applyFilters(Builder $query): Builder
    {
        $criterio = trim((string) $this->criterio);

        if ($criterio !== '') {
            $query->where(function (Builder $propertyQuery) use ($criterio): void {
                $propertyQuery
                    ->where('titulo', 'like', '%' . $criterio . '%')
                    ->orWhere('referencia', 'like', '%' . $criterio . '%')
                    ->orWhereHas('zona', function (Builder $zonaQuery) use ($criterio): void {
                        $zonaQuery->where('zona', 'like', '%' . $criterio . '%');
                    });
            });
        }

        if ($this->estado === 'pendientes') {
            $query->where('aprobada', false);
        }

        if ($this->estado === 'aprobadas') {
            $query->where('aprobada', true);
        }

        return $query;
    }
}
