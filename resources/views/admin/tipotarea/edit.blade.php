@extends('admin.layoutadmin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>TIPO TAREA</h1>
            @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
             @endif
            <form action="{{ route("tipostareas.update",$tipotarea->id) }}" method="post">
                @method("put")
                @csrf
                <div class="form-group">

                    <div class="form-group">
                        <label for="tipo">Tipo Tarea</label>
                        <input type="text" class="form-control" id="todo_tipo" name="todo_tipo" placeholder="tipo"
                            value="{{ $tipotarea->todo_tipo }}">
                    </div>

                    <div class="form-group col-2">
                        <label for="tipo">Color</label>
                        <input type="color" class="form-control" id="color" name="color" placeholder="color"
                            value="{{ $tipotarea->color }}">
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