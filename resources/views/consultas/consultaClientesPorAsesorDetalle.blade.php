@extends('admin.layoutadmin')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>CLIENTES</h1>
            <table class="table table-striped">
                <thead class="bg-primary text-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Precio Min</th>
                        <th scope="col">Precio Max</th>
                        <th scope="col">Fec de Contacto</th>
                        <th scope="col">Creado</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                    <tr>
                        <td scope="row">{{ $cliente->id }}</td>
                        <td>{{ $cliente->nombre }}</td>
                        <td class="text-truncate">{{ $cliente->telefono }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ number_format($cliente->precio_mini) }}</td>
                        <td>{{ number_format($cliente->precio_max) }}</td>
                        <td>{{ $cliente->contact_at }}</td>
                        <td>{{ $cliente->created_at }}</td>
                        <td class="text-center">
                            <a href="/consulta/vercliente/{{ $cliente->id }}">
                                <i class="fa fa-glasses"></i>
                            </a>
                        </td>                        
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection