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
            <form action="{{ route("posts.store") }}" method="post" enctype="multipart/form-data">
                @method("post")
                @csrf
                <div class="form-group">

                    <div class="form-group">
                        <label for="titulo">Titulo</label>
                        <input type="text" class="form-control" maxlength="60" id="titulo" name="titulo" placeholder="titulo" value="{{ old('titulo') }}">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Contenido</label>
                        <textarea class="form-control" id="contenido" name="contenido" required rows="3">{{ old('contenido') }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="metadescription">Meta Description</label>
                        <textarea class="form-control" id="metadescription" name="metadescription" required rows="3">{{ old('metadescription') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" class="form-control-file" name="foto" id="foto"
                            value="{{ old('foto') }}">
                    </div>                    

                    <div class="form-group">
                        <label for="descripcion">Activo?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="activo" name="activo">
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

