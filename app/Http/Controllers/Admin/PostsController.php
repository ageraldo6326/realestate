<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Services\Admin\ContentMediaService;
use App\Services\CatalogoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $search = trim((string) request('search'));

        $posts = Post::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($nestedQuery) use ($search): void {
                    $nestedQuery->where('titulo', 'like', '%' . $search . '%')
                        ->orWhere('contenido', 'like', '%' . $search . '%')
                        ->orWhere('slug', 'like', '%' . $search . '%')
                        ->orWhere('id', 'like', '%' . $search . '%');
                });
            })
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.posts.index', compact('posts', 'search'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(StorePostRequest $request, ContentMediaService $mediaService): RedirectResponse
    {
        $validated = $request->validated();
        $uploadedPhoto = $request->file('foto');

        try {
            DB::transaction(function () use ($validated, $uploadedPhoto, $mediaService, $request): void {
                Post::query()->create([
                    'titulo' => $validated['titulo'],
                    'slug' => $this->generateUniqueSlug($validated['titulo']),
                    'contenido' => $validated['contenido'],
                    'metadescription' => $validated['metadescription'],
                    'autor' => (string) optional($request->user())->name,
                    'activo' => (bool) ($validated['activo'] ?? false),
                    'foto' => $uploadedPhoto ? $mediaService->storeImageAsWebp($uploadedPhoto, 'post', 1400, 900) : null,
                ]);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('posts.index')
                ->with('status', 'Post registrado correctamente.');
        } catch (Throwable $exception) {
            Log::error('posts.store.failed', [
                'titulo' => $validated['titulo'] ?? null,
                'error' => $exception->getMessage(),
                'created_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('posts.create')
                ->withInput()
                ->with('error', 'No fue posible guardar el post. Intenta nuevamente.');
        }

    }

    public function show($id)
    {
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post, ContentMediaService $mediaService): RedirectResponse
    {
        $validated = $request->validated();
        $uploadedPhoto = $request->file('foto');

        try {
            DB::transaction(function () use ($validated, $uploadedPhoto, $post, $mediaService): void {
                $payload = [
                    'titulo' => $validated['titulo'],
                    'slug' => $this->generateUniqueSlug($validated['titulo'], (int) $post->id),
                    'contenido' => $validated['contenido'],
                    'metadescription' => $validated['metadescription'],
                    'activo' => (bool) ($validated['activo'] ?? false),
                ];

                if ($uploadedPhoto) {
                    $payload['foto'] = $mediaService->storeImageAsWebp($uploadedPhoto, 'post', 1400, 900);
                }

                $post->update($payload);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('posts.index')
                ->with('status', 'Post actualizado correctamente.');
        } catch (Throwable $exception) {
            Log::error('posts.update.failed', [
                'post_id' => (int) $post->id,
                'titulo' => $validated['titulo'] ?? null,
                'error' => $exception->getMessage(),
                'updated_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('posts.edit', $post)
                ->withInput()
                ->with('error', 'No fue posible actualizar el post. Intenta nuevamente.');
        }
    }

    public function destroy(Request $request, Post $post): RedirectResponse
    {
        try {
            DB::transaction(function () use ($post): void {
                $post->delete();
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('posts.index')
                ->with('status', 'Post eliminado correctamente.');
        } catch (Throwable $exception) {
            Log::error('posts.delete.failed', [
                'post_id' => (int) $post->id,
                'error' => $exception->getMessage(),
                'deleted_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('posts.index')
                ->with('error', 'No fue posible eliminar el post. Intenta nuevamente.');
        }

    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug !== '' ? $baseSlug : 'post';
        $counter = 2;

        while (Post::query()
            ->when($ignoreId !== null, function ($query) use ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            })
            ->where('slug', $slug)
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
