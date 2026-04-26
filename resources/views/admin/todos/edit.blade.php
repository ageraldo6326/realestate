@extends('admin.layoutadmin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Editar Tarea</h1>
            @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif
            <form action="{{ route("todo.update",$tarea->id) }}" method="post" enctype="multipart/form-data">
                @method("put")
                @csrf
                <div class="form-group">

                    <div class="form-group">
                        <label for="nombre">Tarea</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="tarea" required
                            value="{{ $tarea->nombre }}">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required
                            rows="3">{{ $tarea->descripcion }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="Clientes">Tipo de Tarea</label>
                        <select class="form-control select2 form-control-sm" name="todo_tipo" id="todo_tipo">
                            <option selected>Tipo</option>
                            @foreach ($tipos as $tipo)
                            <option @if ($tarea->todo_tipo==$tipo->id) selected @endif value="{{$tipo->id}}">{{ $tipo->todo_tipo }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="datetime-local" class="form-control" id="fechaLimite" name="fechaLimite"
                            placeholder="Fecha Limite" required value="{{ $tarea->fechaLimite }}">
                    </div>

                    <div class="form-group">
                        <label for="Clientes">Cliente</label>
                        <select class="form-control select2 form-control-sm"" name="cliente_id" id="cliente_id">
                            <option selected>Cliente</option>
                            <option value="0" selected>Empresa</option>
                            @foreach ($clientes as $cliente)
                            <option @if ($tarea->cliente_id==$cliente->id) selected @endif value="{{$cliente->id}}">{{ $cliente->nombre }}</option>
                            @endforeach

                        </select>
                    </div>


                    <div class="form-group">
                        <label for="Clientes">Estatus de la Tarea</label>
                        <select class="form-control select2 form-control-sm"" name="todo_estatus" id="todo_estatus">
                            <option selected>Estatus</option>
                            @foreach ($estatuses as $estatus)
                                <option @if ($tarea->todo_estatus==$estatus->id) selected @endif value="{{$estatus->id}}">{{ $estatus->todo_estatus }}</option>
                            @endforeach

                        </select>
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