<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEstadoRequest;
use App\Http\Requests\Admin\UpdateEstadoRequest;
use App\Models\Estados;
use App\Models\Propiedad;
use App\Services\CatalogoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class EstadosController extends Controller
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
    }

    public function index(Request $request)
    {
        $filtro = trim((string) $request->query('q', ''));

        $estados = Estados::query()
            ->when($filtro !== '', function ($query) use ($filtro) {
                $query->where('estado', 'like', '%' . $filtro . '%');

                if (is_numeric($filtro)) {
                    $query->orWhere('id', (int) $filtro);
                }
            })
            ->orderBy('estado')
            ->paginate(12)
            ->withQueryString();

        return view('admin.estados.index', [
            'estados' => $estados,
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
        return view('admin.estados.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEstadoRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated): void {
                Estados::query()->create([
                    'estado' => $validated['estado'],
                ]);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('estados.index')
                ->with('status', 'Estado registrado correctamente.');
        } catch (Throwable $exception) {
            Log::error('states.store.failed', [
                'estado' => $validated['estado'] ?? null,
                'error' => $exception->getMessage(),
                'created_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('estados.create')
                ->withInput()
                ->with('error', 'No fue posible guardar el estado. Intenta nuevamente.');
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
    public function edit(Estados $estado)
    {
        return view('admin.estados.edit', compact('estado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEstadoRequest $request, Estados $estado): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($estado, $validated): void {
                $estado->update([
                    'estado' => $validated['estado'],
                ]);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('estados.index')
                ->with('status', 'Estado actualizado correctamente.');
        } catch (Throwable $exception) {
            Log::error('states.update.failed', [
                'estado_id' => (int) $estado->id,
                'estado' => $validated['estado'] ?? null,
                'error' => $exception->getMessage(),
                'updated_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('estados.edit', $estado)
                ->withInput()
                ->with('error', 'No fue posible actualizar el estado. Intenta nuevamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Estados $estado): RedirectResponse
    {
        try {
            $propiedadesVinculadas = Propiedad::query()->where('estado_id', $estado->id)->count();

            if ($propiedadesVinculadas > 0) {
                return redirect()
                    ->route('estados.index')
                    ->with('error', 'No se puede borrar el estado porque tiene propiedades relacionadas.');
            }

            DB::transaction(function () use ($estado): void {
                $estado->delete();
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('estados.index')
                ->with('status', 'Estado eliminado correctamente.');
        } catch (Throwable $exception) {
            Log::error('states.delete.failed', [
                'estado_id' => (int) $estado->id,
                'error' => $exception->getMessage(),
                'deleted_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('estados.index')
                ->with('error', 'No fue posible eliminar el estado. Intenta nuevamente.');
        }
    }
}
