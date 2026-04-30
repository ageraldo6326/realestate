<?php

namespace App\Http\Livewire;

use App\Models\TiposDePropiedad;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Propiedad;
use App\Services\CatalogoService;
use Illuminate\Support\Facades\Log;
use Throwable;

class TipoPropiedades extends Component
{
    use WithPagination;

    public $criterio = '';
    protected $listeners = ['borrarTipoPropiedad'];
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $criterio = trim((string) $this->criterio);

        $tipoPropiedades = TiposDePropiedad::query()
            ->when($criterio !== '', function ($query) use ($criterio) {
                $query->where('tipo', 'like', '%' . $criterio . '%');

                if (is_numeric($criterio)) {
                    $query->orWhere('id', (int) $criterio);
                }
            })
            ->orderByDesc('id')
            ->paginate(10);

        // Mantiene compatibilidad si algun flujo legacy aun invoca este componente.
        return view('livewire.buscar-tipo-propiedad', compact('tipoPropiedades'));
    }

    public function updatingCriterio()
    {
        $this->resetPage();
    }

    public function limpiar()
    {
        $this->criterio = '';
        $this->resetPage();
    }

    public function borrarTipoPropiedad($id)
    {
        try {
            $tipoPropiedad = TiposDePropiedad::query()->findOrFail($id);

            $propiedadesVinculadas = Propiedad::query()
                ->where('tipo', $tipoPropiedad->id)
                ->count();

            if ($propiedadesVinculadas > 0) {
                session()->flash('error', 'No se puede eliminar porque tiene propiedades relacionadas.');

                return;
            }

            $tipoPropiedad->delete();
            CatalogoService::forgetAll();

            session()->flash('status', 'Tipo de propiedad eliminado exitosamente.');
            $this->resetPage();
        } catch (Throwable $exception) {
            Log::error('tipo_propiedad.livewire.delete.failed', [
                'tipo_propiedad_id' => (int) $id,
                'error' => $exception->getMessage(),
                'deleted_by' => (int) optional(auth()->user())->id,
            ]);

            session()->flash('error', 'No fue posible eliminar el tipo de propiedad. Intenta nuevamente.');
        }
    }
}
