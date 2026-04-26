@extends('admin.layoutadmin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Testimonios</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
            <form action="{{ route("testimonios.update",$testimonio->id) }}" method="post" enctype="multipart/form-data">
                @method("put")
                @csrf
                <div class="form-group">

                    <div class="form-group">
                        <label for="cliente">Cliente</label>
                        <input type="text" class="form-control" id="cliente" name="cliente" placeholder="cliente" value="{{ $testimonio->cliente }}">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="testimonio" name="testimonio" rows="3">{{ $testimonio->testimonio }}</textarea>
                    </div>  


                    <div class="form-group">
                    <label for="cliente_foto">Foto</label>                    
                    <input type="file" class="form-control-file" name="cliente_foto" id="cliente_foto" value="{{ $testimonio->cliente_foto }}">
                    </div>


                    <div class="form-group">
                        <img class="img-fluid img-thumbnail" width="300px" src="{{ $testimonio->cliente_foto }}" alt="">
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
    CKEDITOR.replace('testimonio');
</script>

@endsection

