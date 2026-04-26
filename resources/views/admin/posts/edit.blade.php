@extends('admin.layoutadmin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>POST</h1>
            @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif
            <form action="{{ route("posts.update",$post->id) }}" method="post" enctype="multipart/form-data">
                @method("put")
                @csrf
                <div class="form-group">

                    <div class="form-group">
                        <label for="titulo">Titulo</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" maxlength="60" placeholder="titulo" value="{{ $post->titulo }}">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Contenido</label>
                        <textarea class="form-control" id="contenido" name="contenido" rows="3">{{ $post->contenido }}</textarea>
                    </div>  

                    <div class="form-group">
                        <label for="metadescription">Meta Description</label>
                        <textarea class="form-control" id="metadescription" name="metadescription" rows="3">{{ $post->metadescription }}</textarea>
                    </div>                    


                    <div class="form-group">
                    <label for="foto">Foto</label>                    
                    <input type="file" class="form-control-file" name="foto" id="foto" value="{{ $post->foto }}">
                    </div>


                    <div class="form-group">
                        <img class="img-fluid img-thumbnail" width="300px" src="{{ $post->foto }}" alt="">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Activo?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" @if ($post->activo==1) checked @endif id="activo" name="activo">
                        </div>
                    </div>                    

                    <div class="form-group">              
                    <input type="submit" class="btn btn-success" name="submit" id="submit" value="Grabar">
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    CKEDITOR.replace('contenido');
</script>

@endsection

