<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTestimonioRequest;
use App\Http\Requests\Admin\UpdateTestimonioRequest;
use App\Models\Testimonio;
use App\Services\Admin\ContentMediaService;
use App\Services\CatalogoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TestimoniosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $search = trim((string) request('search'));

        $testimonios = Testimonio::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($nestedQuery) use ($search): void {
                    $nestedQuery->where('cliente', 'like', '%' . $search . '%')
                        ->orWhere('testimonio', 'like', '%' . $search . '%')
                        ->orWhere('id', 'like', '%' . $search . '%');
                });
            })
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.testimonios.index', compact('testimonios', 'search'));
    }

    public function create()
    {
        return view('admin.testimonios.create');
    }

    public function store(StoreTestimonioRequest $request, ContentMediaService $mediaService): RedirectResponse
    {
        $validated = $request->validated();
        $uploadedPhoto = $request->file('cliente_foto');

        try {
            DB::transaction(function () use ($validated, $uploadedPhoto, $mediaService): void {
                Testimonio::query()->create([
                    'cliente' => $validated['cliente'],
                    'testimonio' => $validated['testimonio'],
                    'cliente_foto' => $uploadedPhoto ? $mediaService->storeImageAsWebp($uploadedPhoto, 'testimonio', 320, 320) : null,
                    'activo' => (bool) ($validated['activo'] ?? true),
                ]);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('testimonios.index')
                ->with('status', 'Testimonio registrado correctamente.');
        } catch (Throwable $exception) {
            Log::error('testimonios.store.failed', [
                'cliente' => $validated['cliente'] ?? null,
                'error' => $exception->getMessage(),
                'created_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('testimonios.create')
                ->withInput()
                ->with('error', 'No fue posible guardar el testimonio. Intenta nuevamente.');
        }
    }

    public function edit(Testimonio $testimonio)
    {
        return view('admin.testimonios.edit', compact('testimonio'));
    }

    public function update(UpdateTestimonioRequest $request, Testimonio $testimonio, ContentMediaService $mediaService): RedirectResponse
    {
        $validated = $request->validated();
        $uploadedPhoto = $request->file('cliente_foto');

        try {
            DB::transaction(function () use ($validated, $uploadedPhoto, $testimonio, $mediaService): void {
                $payload = [
                    'cliente' => $validated['cliente'],
                    'testimonio' => $validated['testimonio'],
                    'activo' => (bool) ($validated['activo'] ?? $testimonio->activo),
                ];

                if ($uploadedPhoto) {
                    $payload['cliente_foto'] = $mediaService->storeImageAsWebp($uploadedPhoto, 'testimonio', 320, 320);
                }

                $testimonio->update($payload);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('testimonios.index')
                ->with('status', 'Testimonio actualizado correctamente.');
        } catch (Throwable $exception) {
            Log::error('testimonios.update.failed', [
                'testimonio_id' => (int) $testimonio->id,
                'cliente' => $validated['cliente'] ?? null,
                'error' => $exception->getMessage(),
                'updated_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('testimonios.edit', $testimonio)
                ->withInput()
                ->with('error', 'No fue posible actualizar el testimonio. Intenta nuevamente.');
        }
    }

    public function destroy(Request $request, Testimonio $testimonio): RedirectResponse
    {
        try {
            DB::transaction(function () use ($testimonio): void {
                $testimonio->delete();
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('testimonios.index')
                ->with('status', 'Testimonio eliminado correctamente.');
        } catch (Throwable $exception) {
            Log::error('testimonios.delete.failed', [
                'testimonio_id' => (int) $testimonio->id,
                'error' => $exception->getMessage(),
                'deleted_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('testimonios.index')
                ->with('error', 'No fue posible eliminar el testimonio. Intenta nuevamente.');
        }
    }
}
