<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

    <form method="GET" action="{{ route("propiedades.index") }}">
        @csrf
        <div class="input-group my-3">
            <input type="text" class="form-control" wire:model='criterio' name="criterio"
                placeholder="Buscar por ID, titulo o zona">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" name="buscar" value="buscar">Buscar</button>
            </div>
        </div>
    </form>


    <div class="row">

        <div class="col-12 ">

            <table class="table mt-0 rounded border table-hover">

                <div class="col-12 shadow-lg mb-1 bg-white">

                    <thead class="bg-info">
                        <tr class="border-0 text-white font-weight-bold rounded-circle">
                            <th>#</th>
                            <th class="text-left">Foto</th>
                            <th>Titulo</th>
                            <th class="d-none d-md-table-cell">Ubicación</th>
                            <th class="d-none d-md-table-cell">Clicks</th>
                            <th class="d-none d-md-table-cell">Creada</th>
                            <th class="col-1 text-start">Action</th>
                        </tr>
                    </thead>

                </div>

                <tbody>

                    @foreach ( $propiedades as $propiedad)
                    <tr>
                        <th scope="row">{{ $propiedad->id}}</th>
                        <td><img src="{{ $propiedad->foto_portada}}" class="" height="50rem" width="100rem"
                                alt=""></td>
                        <td>{{ $propiedad->titulo}}</td>
                        <td class="d-none d-md-table-cell">{{ $propiedad->zona}}</td>
                        <td class="d-none d-md-table-cell">{{ $propiedad->clicks}}</td>
                        <td class="d-none d-md-table-cell">{{ $propiedad->created_at}}</td>
                        <td>
                            <div class="row">
                                <div class="col-12">
                                    <form method="GET" action="{{ route("editarpendientes",$propiedad->id)}}">
                                        {{-- @csrf --}}
                                        <button type="submit" class="btn btn-primary btn-sm btn-block m-1 float-right">Editar</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-2">
                    {{ $propiedades->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>


    </div>

</div>
