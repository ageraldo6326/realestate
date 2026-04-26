@extends('admin.layoutadmin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>TIPO PROPIEDAD</h1>
            @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif
            <form action="{{ route("tipopropiedades.update",$tipopropiedad->id) }}" method="post">
                @method("put")
                @csrf
                <div class="form-group">

                    <div class="form-group">
                        <label for="tipo">Titulo</label>
                        <input type="text" class="form-control" id="tipo" name="tipo" placeholder="tipo"
                            value="{{ $tipopropiedad->tipo }}">
                    </div>


                    <div class="form-group">
                        <input type="submit" class="btn btn-success" name="submit" id="submit" value="Grabar">
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

@endsection