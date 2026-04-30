<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreZonaRequest;
use App\Http\Requests\UpdateZonaRequest;
use App\Models\Zonas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ZonaController extends Controller
{
    /**
     * Mostrar listado de zonas.
     */
    public function index()
    {
        $this->authorize('view', Zonas::class);

        return view('admin.zonas.index');
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $this->authorize('create', Zonas::class);

        return view('admin.zonas.create');
    }

    /**
     * Guardar nueva zona.
     */
    public function store(StoreZonaRequest $request)
    {
        $this->authorize('create', Zonas::class);

        try {
            DB::beginTransaction();

            $zona = Zonas::create($request->validated());

            DB::commit();

            return redirect()
                ->route('zonas.index')
                ->with('success', "Zona '{$zona->zona}' creada exitosamente.");
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Error creando zona: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'data' => $request->validated(),
                'exception' => $e,
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear la zona. Por favor intenta nuevamente.');
        }
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Zonas $zona)
    {
        $this->authorize('update', $zona);

        return view('admin.zonas.edit', compact('zona'));
    }

    /**
     * Actualizar zona.
     */
    public function update(UpdateZonaRequest $request, Zonas $zona)
    {
        $this->authorize('update', $zona);

        try {
            DB::beginTransaction();

            $zona->update($request->validated());

            DB::commit();

            return redirect()
                ->route('zonas.index')
                ->with('success', "Zona '{$zona->zona}' actualizada exitosamente.");
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Error actualizando zona: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'zona_id' => $zona->id,
                'data' => $request->validated(),
                'exception' => $e,
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar la zona. Por favor intenta nuevamente.');
        }
    }

    /**
     * Eliminar zona.
     */
    public function destroy(Zonas $zona)
    {
        $this->authorize('delete', $zona);

        try {
            DB::beginTransaction();

            $nombre = $zona->zona;
            $zona->delete();

            DB::commit();

            return redirect()
                ->route('zonas.index')
                ->with('success', "Zona '{$nombre}' eliminada exitosamente.");
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Error eliminando zona: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'zona_id' => $zona->id,
                'exception' => $e,
            ]);

            return redirect()
                ->back()
                ->with('error', 'Error al eliminar la zona. Por favor intenta nuevamente.');
        }
    }
}
