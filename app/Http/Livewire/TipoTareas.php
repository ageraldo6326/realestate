<?php

namespace App\Http\Livewire;

use App\Models\ToDo;
use App\Models\ToDoTipo;
use App\Services\CatalogoService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class TipoTareas extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['borrarTipoTarea'];

    public $criterio = '';

    public function render()
    {
        $criterio = trim((string) $this->criterio);

        $tipostareas = ToDoTipo::query()
            ->when($criterio !== '', function ($query) use ($criterio) {
                $query->where('todo_tipo', 'like', '%' . $criterio . '%');

                if (is_numeric($criterio)) {
                    $query->orWhere('id', (int) $criterio);
                }
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.tipo-tareas', compact('tipostareas'));
    }

    public function updatingCriterio(): void
    {
        $this->resetPage();
    }

    public function limpiar(): void
    {
        $this->criterio = '';
        $this->resetPage();
    }

    public function borrarTipoTarea($id): void
    {
        try {
            $tipoTarea = ToDoTipo::query()->findOrFail((int) $id);

            $tareasVinculadas = ToDo::query()->where('todo_tipo', $tipoTarea->id)->count();

            if ($tareasVinculadas > 0) {
                session()->flash('error', 'No se puede eliminar porque tiene tareas relacionadas.');

                return;
            }

            $tipoTarea->delete();
            CatalogoService::forgetAll();

            session()->flash('status', 'Tipo de tarea eliminado correctamente.');
            $this->resetPage();
        } catch (Throwable $exception) {
            Log::error('todo_types.livewire.delete.failed', [
                'todo_tipo_id' => (int) $id,
                'error' => $exception->getMessage(),
                'deleted_by' => (int) optional(auth()->user())->id,
            ]);

            session()->flash('error', 'No fue posible eliminar el tipo de tarea. Intenta nuevamente.');
        }
    }
}
