<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view("admin.posts.index",compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.posts.create");
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

        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
            'metadescription' => 'required'                
        ]);

        $post = New Post();

        $post->titulo = $request->titulo;
        $post->slug = Str::slug($request->titulo);
        $post->contenido = $request->contenido;
        $post->metadescription = $request->metadescription;
        $post->autor = Auth::user()->name;

        if ($request->hasFile('foto')) {

            $urlfoto = $request->file("foto");
  
            $post->foto = '/img/post/' . $request->file("foto")->getClientOriginalName(); 
              
            $ruta = public_path('/img/post/').$request->file("foto")->getClientOriginalName();
          
            copy($urlfoto->getRealPath(),$ruta);
        }    
        
        if ($request->has('activo')) {
            $post->activo =1;
        } else {
            $post->activo=0;
        }

        $post->save();

        return redirect()->route("posts.index");

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
        //
        $post = Post::where('id',$id)->first();

        return view("admin.posts.edit", compact("post"));
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


        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
            'metadescription' => 'required'                
        ]);

        $post = Post::where('id',$id)->first();
              

        $post->titulo = $request->titulo;
        $post->slug = Str::slug($request->titulo);
        $post->contenido = $request->contenido;
        $post->metadescription = $request->metadescription;

       

        if ($request->hasFile('foto')) {

            $urlfoto = $request->file("foto");
  
            $post->foto = '/img/post/' . $request->file("foto")->getClientOriginalName(); 
              
            $ruta = public_path('/img/post/').$request->file("foto")->getClientOriginalName();
          
            copy($urlfoto->getRealPath(),$ruta);
        }        

        if ($request->has('activo')) {
            $post->activo = 1;
        } else {
            $post->activo = 0;
        }
 

        $post->save();

        return redirect()->route("posts.index");        
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
        $post = Post::where('id',$id)->first();
        $post->delete();

        return redirect()->route("posts.index");

    }
}
