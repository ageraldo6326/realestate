<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\InmobiliariaService;
use App\Services\SeoMetadataService;
use Illuminate\Http\RedirectResponse;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SeoMetadataService $seoMetadataService)
    {
        //
        $inmobiliaria = InmobiliariaService::get();

        $posts = Post::query()->published()->orderByDesc('published_at')->paginate(12);
        $seo = $seoMetadataService->forBlog($inmobiliaria, (int) $request->query('page', 1));

        return view("frontend.blog", compact("inmobiliaria", "posts", "seo"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug, SeoMetadataService $seoMetadataService)
    {
        $post = Post::query()->published()->where('slug', $slug)->firstOrFail();
        $inmobiliaria = InmobiliariaService::get();
        $seo = $seoMetadataService->forPost($post, $inmobiliaria);

        return view("frontend.post", compact("post", "inmobiliaria", "seo"));

    }

    public function legacyRedirect(string $slug): RedirectResponse
    {
        abort_unless(Post::query()->published()->where('slug', $slug)->exists(), 404);

        return redirect()->route('post.show', ['slug' => $slug], 301);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
