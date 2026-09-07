<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreZonaRequest;
use App\Http\Requests\Admin\UpdateZonaRequest;
use App\Models\Clientes;
use App\Models\Propiedad;
use App\Models\Zonas;
use App\Services\CatalogoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ZonasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * 
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|superadmin');
    }

    public function index(Request $request)
    {
        $filtro = trim((string) $request->query('q', ''));

        $zonas = Zonas::query()
            ->when($filtro !== '', function ($query) use ($filtro) {
                $query->where('zona', 'like', '%' . $filtro . '%');

                if (is_numeric($filtro)) {
                    $query->orWhere('id', (int) $filtro);
                }
            })
            ->orderBy('zona')
            ->paginate(12)
            ->withQueryString();

        return view('admin.zonas.index', [
            'zonas' => $zonas,
            'filtro' => $filtro,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.zonas.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreZonaRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated): void {
                Zonas::query()->create([
                    'zona' => $validated['zona'],
                ]);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('zonas.index')
                ->with('status', 'Zona registrada correctamente.');
        } catch (Throwable $exception) {
            Log::error('zones.store.failed', [
                'zona' => $validated['zona'] ?? null,
                'error' => $exception->getMessage(),
                'created_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('zonas.create')
                ->withInput()
                ->with('error', 'No fue posible guardar la zona. Intenta nuevamente.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Zonas $zona)
    {
        return view('admin.zonas.edit', compact('zona'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateZonaRequest $request, Zonas $zona): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($zona, $validated): void {
                $zona->update([
                    'zona' => $validated['zona'],
                ]);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('zonas.index')
                ->with('status', 'Zona actualizada correctamente.');
        } catch (Throwable $exception) {
            Log::error('zones.update.failed', [
                'zona_id' => (int) $zona->id,
                'zona' => $validated['zona'] ?? null,
                'error' => $exception->getMessage(),
                'updated_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('zonas.edit', $zona)
                ->withInput()
                ->with('error', 'No fue posible actualizar la zona. Intenta nuevamente.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Zonas $zona): RedirectResponse
    {
        try {
            $propiedadesVinculadas = Propiedad::query()->where('zona_id', $zona->id)->count();
            $clientesVinculados = Clientes::query()->where('zona_id', $zona->id)->count();

            if (($propiedadesVinculadas + $clientesVinculados) > 0) {
                return redirect()
                    ->route('zonas.index')
                    ->with('error', 'No se puede borrar la zona porque tiene propiedades o clientes relacionados.');
            }

            DB::transaction(function () use ($zona): void {
                $zona->delete();
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('zonas.index')
                ->with('status', 'Zona eliminada correctamente.');
        } catch (Throwable $exception) {
            Log::error('zones.delete.failed', [
                'zona_id' => (int) $zona->id,
                'error' => $exception->getMessage(),
                'deleted_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('zonas.index')
                ->with('error', 'No fue posible eliminar la zona. Intenta nuevamente.');
        }
    }
}
