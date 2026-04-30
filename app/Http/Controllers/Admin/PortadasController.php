<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StorePortadaRequest;
use App\Http\Requests\Admin\UpdatePortadaRequest;
use App\Models\Portada;
use App\Http\Controllers\Controller;
use App\Services\Admin\ContentMediaService;
use App\Services\CatalogoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PortadasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $search = trim((string) request('search'));

        $portadas = Portada::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($nestedQuery) use ($search): void {
                    $nestedQuery->where('titulo', 'like', '%' . $search . '%')
                        ->orWhere('minititulo', 'like', '%' . $search . '%')
                        ->orWhere('id', 'like', '%' . $search . '%');
                });
            })
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.portadas.index', compact('portadas', 'search'));
    }

    public function create()
    {
        return view('admin.portadas.create');
    }

    public function store(StorePortadaRequest $request, ContentMediaService $mediaService): RedirectResponse
    {
        $validated = $request->validated();
        $uploadedPhoto = $request->file('foto');

        try {
            DB::transaction(function () use ($validated, $uploadedPhoto, $mediaService): void {
                Portada::query()->create([
                    'minititulo' => $validated['minititulo'],
                    'titulo' => $validated['titulo'],
                    'descripcion' => $validated['descripcion'] ?? null,
                    'url1' => $validated['url1'] ?? null,
                    'url2' => $validated['url2'] ?? null,
                    'enlace1' => $validated['enlace1'] ?? null,
                    'enlace2' => $validated['enlace2'] ?? null,
                    'video' => $mediaService->extractYoutubeVideoId($validated['video'] ?? null) ?? ($validated['video'] ?? null),
                    'foto' => $uploadedPhoto ? $mediaService->storeImageAsWebp($uploadedPhoto, 'portada', 1600, 900) : null,
                ]);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('portadas.index')
                ->with('status', 'Portada registrada correctamente.');
        } catch (Throwable $exception) {
            Log::error('portadas.store.failed', [
                'titulo' => $validated['titulo'] ?? null,
                'error' => $exception->getMessage(),
                'created_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('portadas.create')
                ->withInput()
                ->with('error', 'No fue posible guardar la portada. Intenta nuevamente.');
        }
    }

    public function destroy(Request $request, Portada $portada): RedirectResponse
    {
        try {
            DB::transaction(function () use ($portada): void {
                $portada->delete();
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('portadas.index')
                ->with('status', 'Portada eliminada correctamente.');
        } catch (Throwable $exception) {
            Log::error('portadas.delete.failed', [
                'portada_id' => (int) $portada->id,
                'error' => $exception->getMessage(),
                'deleted_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('portadas.index')
                ->with('error', 'No fue posible eliminar la portada. Intenta nuevamente.');
        }
    }

    public function edit(Portada $portada)
    {
        return view('admin.portadas.edit', compact('portada'));
    }

    public function update(UpdatePortadaRequest $request, Portada $portada, ContentMediaService $mediaService): RedirectResponse
    {
        $validated = $request->validated();
        $uploadedPhoto = $request->file('foto');

        try {
            DB::transaction(function () use ($validated, $uploadedPhoto, $portada, $mediaService): void {
                $payload = [
                    'minititulo' => $validated['minititulo'],
                    'titulo' => $validated['titulo'],
                    'descripcion' => $validated['descripcion'] ?? null,
                    'url1' => $validated['url1'] ?? null,
                    'url2' => $validated['url2'] ?? null,
                    'enlace1' => $validated['enlace1'] ?? null,
                    'enlace2' => $validated['enlace2'] ?? null,
                    'video' => $mediaService->extractYoutubeVideoId($validated['video'] ?? null) ?? ($validated['video'] ?? null),
                ];

                if ($uploadedPhoto) {
                    $payload['foto'] = $mediaService->storeImageAsWebp($uploadedPhoto, 'portada', 1600, 900);
                }

                $portada->update($payload);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('portadas.index')
                ->with('status', 'Portada actualizada correctamente.');
        } catch (Throwable $exception) {
            Log::error('portadas.update.failed', [
                'portada_id' => (int) $portada->id,
                'titulo' => $validated['titulo'] ?? null,
                'error' => $exception->getMessage(),
                'updated_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('portadas.edit', $portada)
                ->withInput()
                ->with('error', 'No fue posible actualizar la portada. Intenta nuevamente.');
        }
    }
}
