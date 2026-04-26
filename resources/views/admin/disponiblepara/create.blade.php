@extends('admin.layoutadmin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>DISPONIBLE PARA</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif            
            <form action="{{ route("disponiblepara.store") }}" method="post">
                @method("post")
                @csrf
                <div class="form-group">

                    <div class="form-group">
                        <label for="titulo">Disponible para</label>
                        <input type="text" class="form-control" id="disponible_para" name="disponible_para" placeholder="Disponible para"
                            value="{{ old('estado') }}">
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