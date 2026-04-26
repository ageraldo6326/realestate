@extends('admin.layoutadmin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>ENFOQUE</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
            <form action="{{ route("enfoques.update",$enfoque->id) }}" method="post" enctype="multipart/form-data">
                @method("put")
                @csrf
                <div class="form-group">

                    <div class="form-group">
                        <label for="titulo">Titulo</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="titulo" value="{{ $enfoque->titulo }}">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Enfoque</label>
                        <textarea class="form-control" id="enfoque" name="enfoque" rows="3">{{ $enfoque->enfoque }}</textarea>
                    </div>         
                    
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" class="form-control-file" name="foto" id="foto" value="{{ $enfoque->foto }}">
                    </div>
                    
                    
                    <div class="form-group">
                        <img class="img-fluid img-thumbnail" width="300px" src="{{ $enfoque->foto }}" alt="">
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
    CKEDITOR.replace('enfoque');
</script>

@endsection

