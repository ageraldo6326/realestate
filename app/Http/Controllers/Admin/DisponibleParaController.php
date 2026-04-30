<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDisponibleParaRequest;
use App\Http\Requests\Admin\UpdateDisponibleParaRequest;
use App\Models\Disponible_para;
use App\Models\Propiedad;
use App\Services\CatalogoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class DisponibleParaController extends Controller
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
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('admin.disponiblepara.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.disponiblepara.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDisponibleParaRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated): void {
                Disponible_para::query()->create([
                    'disponible_para' => $validated['disponible_para'],
                ]);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('disponiblepara.index')
                ->with('status', 'Disponible para registrado correctamente.');
        } catch (Throwable $exception) {
            Log::error('disponible_para.store.failed', [
                'disponible_para' => $validated['disponible_para'] ?? null,
                'error' => $exception->getMessage(),
                'created_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('disponiblepara.create')
                ->withInput()
                ->with('error', 'No fue posible guardar el registro. Intenta nuevamente.');
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
    public function edit($id)
    {
        $disponiblepara = Disponible_para::query()->findOrFail($id);

        return view('admin.disponiblepara.edit', compact('disponiblepara'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDisponibleParaRequest $request, $id): RedirectResponse
    {
        $validated = $request->validated();
        $disponiblepara = Disponible_para::query()->findOrFail($id);

        try {
            DB::transaction(function () use ($disponiblepara, $validated): void {
                $disponiblepara->update([
                    'disponible_para' => $validated['disponible_para'],
                ]);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('disponiblepara.index')
                ->with('status', 'Disponible para actualizado correctamente.');
        } catch (Throwable $exception) {
            Log::error('disponible_para.update.failed', [
                'disponible_para_id' => (int) $disponiblepara->id,
                'disponible_para' => $validated['disponible_para'] ?? null,
                'error' => $exception->getMessage(),
                'updated_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('disponiblepara.edit', $disponiblepara->id)
                ->withInput()
                ->with('error', 'No fue posible actualizar el registro. Intenta nuevamente.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        $disponiblepara = Disponible_para::query()->findOrFail($id);

        try {
            $propiedadesVinculadas = Propiedad::query()
                ->where('disponible_para', $disponiblepara->id)
                ->count();

            if ($propiedadesVinculadas > 0) {
                return redirect()
                    ->route('disponiblepara.index')
                    ->with('error', 'No se puede eliminar porque tiene propiedades relacionadas.');
            }

            DB::transaction(function () use ($disponiblepara): void {
                $disponiblepara->delete();
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('disponiblepara.index')
                ->with('status', 'Disponible para eliminado correctamente.');
        } catch (Throwable $exception) {
            Log::error('disponible_para.delete.failed', [
                'disponible_para_id' => (int) $disponiblepara->id,
                'error' => $exception->getMessage(),
                'deleted_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('disponiblepara.index')
                ->with('error', 'No fue posible eliminar el registro. Intenta nuevamente.');
        }

    }
}
