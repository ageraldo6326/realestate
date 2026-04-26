@extends('admin.layoutadmin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Testimonio</h1>
            

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route("testimonios.store") }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">

                    <div class="form-group">
                        <label for="cliente">Cliente</label>
                        <input type="text" class="form-control" id="cliente" name="cliente" placeholder="cliente" required value="{{ old('nombre') }}">
                    </div>

                    <div class="form-group">
                        <label for="testimonio">Testimonio</label>
                        <textarea class="form-control" id="testimonio" name="testimonio" required rows="3">{{ old('testimonio') }}</textarea>
                    </div>                    

                    <div class="form-group">
                    <label for="clientefoto">Foto</label>                    
                    <input type="file" class="form-control-file" name="cliente_foto" id="cliente_foto" value="{{ old('cliente_foto') }}">
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

