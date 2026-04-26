<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>ZONAS 1</h1>
                <div class="m-3 col-12 text-end">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalForm">Nuevo</button>
                </div>
                <div class="input-group my-3">
                    <input type="text" class="form-control" wire:model='criterio' name="criterio" placeholder="Buscar...">
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>N</th>
                            <th>Zona</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($zonas as $zona)
                        <tr>
                            <td scope="row">{{ $zona->id }}</td>
                            <td>{{ $zona->zona }}</td>
                            <td class="text-center">
                                <div class="justify-content-end">
                                        <button type="button" class="btn btn-primary btn-sm btn-block m-1 rounded" wire:click='edit({{ $zona->id }})' data-toggle="modal" data-target="#modalForm">Editar</button>
                                        <button type="button" class="btn btn-danger btn-sm btn-block m-1 rounded" wire:click='edit({{ $zona->id }})' data-toggle="modal" data-target="#modalFormDelete">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $zonas->links('pagination::bootstrap-4') }}
            </div>

        </div>
        

    </div>



    @include('components.modalheader')

    <div class="mb-3">
        <label for="" class="form-label">Zona</label>
        <input type="text" class="form-control" wire:model.lazy='zonaName' aria-describedby="helpId" placeholder="zona">
        @error('zonaName') <span class="error text-danger">{{ $message }}</span> @enderror
    </div>
    
    @include('components.modalfooter')

    @include('components.modalheaderdelete')
    
    <div class="mb-3">
        <label for="" class="form-label">Zona</label>
        <input type="text" disabled class="form-control" wire:model.lazy='zonaName' aria-describedby="helpId" placeholder="zona">
    </div>
    
    @include('components.modalfooterdelete')    

</div>