@extends('admin.layoutadmin')

@section('content')
<div class="container">
<div class="row">

    <div class="col-12">

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route("portadas.store") }}" method="POST" enctype="multipart/form-data">
            @csrf            
           
            <div class="form-group">
                <label for="minititulo">Titulo</label>
                <input type="text" class="form-control" id="minititulo" name="minititulo" value="{{ old('minititulo') }}" placeholder="Mini Titulo"
                    required maxlength="60">
            </div>

            <div class="form-group">
                <label for="titulo">Titulo</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo') }}" placeholder="Titulo"
                    required maxlength="60">
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" placeholder="Descripción" maxlength="350" id="descripcion" name="descripcion"
                    style="height: 100px">{{ old('descripcion') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Foto</label>
                <input class="form-control" maxlength="100" type="file" id="foto" name="foto" value="{{ old('foto') }}" required>
            </div>  
            
            <div class="form-group">
                <label for="enlace1">Enlace 1</label>
                <input type="text" maxlength="100" class="form-control" id="enlace1" name="enlace1" value="{{ old('enlace1') }}" placeholder="Enlace 1">
            </div>
            
            <div class="form-group">
                <label for="url1">Url 1</label>
                <input type="text" maxlength="100" class="form-control" id="url1" name="url1" value="{{ old('url1') }}" placeholder="URL 1">
            </div>
                                
            <div class="form-group">
                <label for="formFile" class="form-label">Video</label>
                <input class="form-control" maxlength="100" type="text" id="video" name="video" value="{{ old('video') }}">
            </div>

            <button type="submit" class="btn btn-primary m-3" value="grabar" name="grabar">Grabar</button>
        </form>
    </div>

</div>
</div>


{{-- <script>
            CKEDITOR.replace( 'descripcion' );
</script> --}}

@endsection