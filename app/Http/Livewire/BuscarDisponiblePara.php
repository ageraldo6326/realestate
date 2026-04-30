<?php

namespace App\Http\Livewire;

use App\Models\Disponible_para;
use App\Models\Propiedad;
use App\Services\CatalogoService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Throwable;

class BuscarDisponiblePara extends Component
{
    use WithPagination;

    protected $listeners = ['borrarDisponiblePara'];
    protected $paginationTheme = 'bootstrap';

    public $criterio = '';

    public function render()
    {
        $criterio = trim((string) $this->criterio);

        $disponiblespara = Disponible_para::query()
            ->when($criterio !== '', function ($query) use ($criterio) {
                $query->where('disponible_para', 'like', '%' . $criterio . '%');

                if (is_numeric($criterio)) {
                    $query->orWhere('id', (int) $criterio);
                }
            })
            ->orderByDesc('id')
            ->paginate(12);

        return view('livewire.buscar-disponible-para', compact('disponiblespara'));
    }

    public function updatingCriterio()
    {
        $this->resetPage();
    }

    public function clear()
    {
        $this->criterio = '';

        $this->resetPage();
    }

    public function borrarDisponiblePara($id)
    {
        try {
            $disponiblePara = Disponible_para::query()->findOrFail($id);

            $propiedadesVinculadas = Propiedad::query()
                ->where('disponible_para', $disponiblePara->id)
                ->count();

            if ($propiedadesVinculadas > 0) {
                session()->flash('error', 'No se puede eliminar porque tiene propiedades relacionadas.');

                return;
            }

            $disponiblePara->delete();
            CatalogoService::forgetAll();

            session()->flash('status', 'Registro eliminado correctamente.');
            $this->resetPage();
        } catch (Throwable $exception) {
            Log::error('disponible_para.livewire.delete.failed', [
                'disponible_para_id' => (int) $id,
                'error' => $exception->getMessage(),
                'deleted_by' => (int) optional(auth()->user())->id,
            ]);

            session()->flash('error', 'No fue posible eliminar el registro. Intenta nuevamente.');
        }
    }
}
