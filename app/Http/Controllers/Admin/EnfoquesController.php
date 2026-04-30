<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEnfoqueRequest;
use App\Http\Requests\Admin\UpdateEnfoqueRequest;
use App\Models\Enfoque;
use App\Services\Admin\ContentMediaService;
use App\Services\CatalogoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class EnfoquesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $search = trim((string) request('search'));

        $enfoques = Enfoque::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($nestedQuery) use ($search): void {
                    $nestedQuery->where('titulo', 'like', '%' . $search . '%')
                        ->orWhere('enfoque', 'like', '%' . $search . '%')
                        ->orWhere('id', 'like', '%' . $search . '%');
                });
            })
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.enfoques.index', compact('enfoques', 'search'));
    }

    public function edit(Enfoque $enfoque)
    {
        return view('admin.enfoques.edit', compact('enfoque'));
    }

    public function update(UpdateEnfoqueRequest $request, Enfoque $enfoque, ContentMediaService $mediaService): RedirectResponse
    {
        $validated = $request->validated();
        $uploadedPhoto = $request->file('foto');

        try {
            DB::transaction(function () use ($validated, $uploadedPhoto, $enfoque, $mediaService): void {
                $payload = [
                    'titulo' => $validated['titulo'],
                    'enfoque' => $validated['enfoque'],
                ];

                if ($uploadedPhoto) {
                    $payload['foto'] = $mediaService->storeImageAsWebp($uploadedPhoto, 'enfoque', 800, 900);
                }

                $enfoque->update($payload);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('enfoques.index')
                ->with('status', 'Enfoque actualizado correctamente.');
        } catch (Throwable $exception) {
            Log::error('enfoques.update.failed', [
                'enfoque_id' => (int) $enfoque->id,
                'titulo' => $validated['titulo'] ?? null,
                'error' => $exception->getMessage(),
                'updated_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('enfoques.edit', $enfoque)
                ->withInput()
                ->with('error', 'No fue posible actualizar el enfoque. Intenta nuevamente.');
        }
    }

    public function create()
    {
        return view('admin.enfoques.create');
    }

    public function destroy(Request $request, Enfoque $enfoque): RedirectResponse
    {
        try {
            DB::transaction(function () use ($enfoque): void {
                $enfoque->delete();
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('enfoques.index')
                ->with('status', 'Enfoque eliminado correctamente.');
        } catch (Throwable $exception) {
            Log::error('enfoques.delete.failed', [
                'enfoque_id' => (int) $enfoque->id,
                'error' => $exception->getMessage(),
                'deleted_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('enfoques.index')
                ->with('error', 'No fue posible eliminar el enfoque. Intenta nuevamente.');
        }
    }

    public function store(StoreEnfoqueRequest $request, ContentMediaService $mediaService): RedirectResponse
    {
        $validated = $request->validated();
        $uploadedPhoto = $request->file('foto');

        try {
            DB::transaction(function () use ($validated, $uploadedPhoto, $mediaService): void {
                Enfoque::query()->create([
                    'titulo' => $validated['titulo'],
                    'enfoque' => $validated['enfoque'],
                    'foto' => $uploadedPhoto ? $mediaService->storeImageAsWebp($uploadedPhoto, 'enfoque', 800, 900) : null,
                ]);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('enfoques.index')
                ->with('status', 'Enfoque registrado correctamente.');
        } catch (Throwable $exception) {
            Log::error('enfoques.store.failed', [
                'titulo' => $validated['titulo'] ?? null,
                'error' => $exception->getMessage(),
                'created_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('enfoques.create')
                ->withInput()
                ->with('error', 'No fue posible guardar el enfoque. Intenta nuevamente.');
        }
    }    
}
