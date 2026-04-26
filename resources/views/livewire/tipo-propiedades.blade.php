<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>TIPO PROPIEDAD</h1>
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
                            <th>Tipo</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tipoPropiedades as $tipopropiedad)
                        <tr>
                            <td scope="row">{{ $tipopropiedad->id }}</td>
                            <td>{{ $tipopropiedad->tipo }}</td>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary btn-block btn-sm m-1 rounded" wire:click='edit({{ $tipopropiedad->id }})' data-toggle="modal" data-target="#modalForm">Editar</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-danger btn-block btn-sm m-1 rounded" wire:click='edit({{ $tipopropiedad->id }})'  data-toggle="modal" data-target="#modalFormDelete">Eliminar</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
    
                    </tbody>
                </table>
                {{ $tipoPropiedades->links('pagination::bootstrap-4') }}
            </div>
    
        </div>
    
    </div>

    @include('components.modalheader')
    
    <div class="mb-3">
        <label for="" class="form-label">Tipo Propiedad</label>
        <input type="text" class="form-control" wire:model.lazy='tipo' placeholder="Tipo propiedad">
        @error('tipo') <span class="error text-danger">* {{ $message }}</span> @enderror
    </div>
    
    @include('components.modalfooter')
    
    @include('components.modalheaderdelete')
    
    <div class="mb-3">
        <label for="" class="form-label">Tipo Propiedad</label>
        <input type="text" disabled class="form-control" wire:model.lazy='tipo' placeholder="Tipo propiedad">
    </div>
    
    @include('components.modalfooterdelete')    
</div>
