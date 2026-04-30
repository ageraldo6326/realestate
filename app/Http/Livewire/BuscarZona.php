<?php

namespace App\Http\Livewire;

use App\Models\Clientes;
use App\Models\Propiedad;
use App\Models\Zonas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class BuscarZona extends Component
{

    use WithPagination;

    protected $listeners = ['borrarZona'];
    protected $paginationTheme = 'bootstrap';

    public $Id = 0;
    public $criterio = '';
    public $zona = '';

    protected function rules(): array
    {
        return [
            'zona' => [
                'required',
                'string',
                'min:2',
                'max:50',
                Rule::unique('zonas', 'zona')->ignore($this->Id),
            ],
        ];
    }

    protected $validationAttributes = [
        'zona' => 'zona',
    ];

    public function render()
    {
        $criterio = trim((string) $this->criterio);

        $zonas = Zonas::query()
            ->where(function ($query) use ($criterio) {
                $query->where('zona', 'like', '%' . $criterio . '%');

                if ($criterio !== '' && is_numeric($criterio)) {
                    $query->orWhere('id', '=', (int) $criterio);
                }
            })
            ->orderByDesc('id')
            ->paginate(6);

        return view('livewire.buscar-zona', compact('zonas'));
    }

    public function updatingCriterio(): void
    {
        $this->resetPage();
    }

    public function updatedZona($value): void
    {
        $this->zona = $this->normalizeZona((string) $value);
        $this->validateOnly('zona');
    }

    public function save(): void
    {
        if ((int) $this->Id === 0) {
            $this->store();

            return;
        }

        $this->update((int) $this->Id);
    }

    public function borrarZona($id): void
    {
        $zonaId = (int) $id;

        try {
            $zona = Zonas::query()->find($zonaId);

            if (!$zona) {
                $this->dispatchBrowserEvent('zona-operation-result', [
                    'type' => 'warning',
                    'message' => 'La zona ya no existe o fue eliminada por otro usuario.',
                ]);

                return;
            }

            $propiedadesVinculadas = Propiedad::query()->where('zona_id', $zonaId)->count();
            $clientesVinculados = Clientes::query()->where('zona_id', $zonaId)->count();

            if (($propiedadesVinculadas + $clientesVinculados) > 0) {
                $this->dispatchBrowserEvent('zona-operation-result', [
                    'type' => 'warning',
                    'message' => 'No se puede borrar la zona porque tiene registros relacionados.',
                ]);

                return;
            }

            DB::transaction(function () use ($zona): void {
                $zona->delete();
            });

            session()->flash('status', 'Zona eliminada exitosamente.');

            $this->dispatchBrowserEvent('zona-operation-result', [
                'type' => 'success',
                'message' => 'Zona eliminada correctamente.',
            ]);
        } catch (Throwable $exception) {
            Log::error('Error al eliminar zona.', [
                'zona_id' => $zonaId,
                'error' => $exception->getMessage(),
            ]);

            $this->dispatchBrowserEvent('zona-operation-result', [
                'type' => 'error',
                'message' => 'Ocurrio un error al eliminar la zona. Intenta nuevamente.',
            ]);
        }
    }

    public function edit($id): void
    {
        $zona = Zonas::query()->find((int) $id);

        if (!$zona) {
            $this->dispatchBrowserEvent('zona-operation-result', [
                'type' => 'warning',
                'message' => 'La zona seleccionada ya no esta disponible.',
            ]);

            return;
        }

        $this->zona = (string) $zona->zona;
        $this->Id = (int) $zona->id;
        $this->resetValidation();
    }

    public function clear(): void
    {
        $this->zona = '';
        $this->Id = 0;
        $this->resetValidation();
    }

    public function store(): void
    {
        $validated = $this->validate();

        try {
            $nombreZona = $this->normalizeZona((string) $validated['zona']);

            DB::transaction(function () use ($nombreZona): void {
                Zonas::query()->create([
                    'zona' => $nombreZona,
                ]);
            });

            session()->flash('status', 'Zona guardada exitosamente.');

            $this->clear();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('zona-operation-result', [
                'type' => 'success',
                'message' => 'Zona registrada correctamente.',
            ]);
        } catch (Throwable $exception) {
            Log::error('Error al crear zona.', [
                'zona' => $this->zona,
                'error' => $exception->getMessage(),
            ]);

            $this->addError('zona', 'No se pudo guardar la zona. Verifica los datos e intenta de nuevo.');
        }
    }

    public function update($id): void
    {
        $zonaId = (int) $id;
        $validated = $this->validate();

        try {
            $nombreZona = $this->normalizeZona((string) $validated['zona']);

            $zona = Zonas::query()->find($zonaId);

            if (!$zona) {
                $this->addError('zona', 'La zona que intentas editar ya no existe.');

                return;
            }

            DB::transaction(function () use ($zona, $nombreZona): void {
                $zona->zona = $nombreZona;
                $zona->save();
            });

            session()->flash('status', 'Zona actualizada exitosamente.');

            $this->clear();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('zona-operation-result', [
                'type' => 'success',
                'message' => 'Zona actualizada correctamente.',
            ]);
        } catch (Throwable $exception) {
            Log::error('Error al actualizar zona.', [
                'zona_id' => $zonaId,
                'zona' => $this->zona,
                'error' => $exception->getMessage(),
            ]);

            $this->addError('zona', 'No se pudo actualizar la zona. Intenta nuevamente.');
        }
    }

    private function normalizeZona(string $value): string
    {
        $normalized = preg_replace('/\s+/u', ' ', trim($value));

        return $normalized ?? '';
    }
}
