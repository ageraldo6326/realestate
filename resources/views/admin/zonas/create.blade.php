@extends('admin.layoutadmin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>ZONA</h1>
            @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif
            <form action="{{ route("zonas.store") }}" method="post" enctype="multipart/form-data">
                @method("post")
                @csrf
                <div class="form-group">

                    <div class="form-group">
                        <label for="titulo">Zona</label>
                        <input type="text" class="form-control" id="zona" name="zona" placeholder="zona" value="{{ old('zona') }}">
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

