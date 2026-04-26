<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>DISPONIBLE PARA</h1>
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
                            <th>Disponible para</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($disponiblespara as $disponiblepara)
                        <tr>
                            <td scope="row">{{ $disponiblepara->id }}</td>
                            <td>{{ $disponiblepara->disponible_para }}</td>

                            <td class="text-end">
                                <div class="div">
                                    <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-sm btn-block m-1 rounded" wire:click='edit({{ $disponiblepara->id }})'
                                        data-toggle="modal" data-target="#modalForm">Editar</button>
                                    </div>
                                    <div class="col-md-6">
                                    <button type="button" class="btn btn-danger btn-sm btn-block m-1 rounded" wire:click='edit({{ $disponiblepara->id }})'
                                        data-toggle="modal" data-target="#modalFormDelete">Eliminar</button>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        @endforeach
    
                    </tbody>
                </table>
                {{ $disponiblespara->links('pagination::bootstrap-4') }}
            </div>
    
        </div>
    
    </div>

    @include('components.modalheader')
    
    <div class="mb-3">
        <label for="" class="form-label">Disponible para</label>
        <input type="text" class="form-control" wire:model.lazy='disponible_para' placeholder="Disponible Para">
        @error('disponible_para') <span class="error text-danger">*{{ $message }}</span> @enderror
    </div>
    
    @include('components.modalfooter')
    
    @include('components.modalheaderdelete')
    
    <div class="mb-3">
        <label for="" class="form-label">Disponible para</label>
        <input type="text" disabled class="form-control" wire:model.lazy='disponible_para' placeholder="Disponible para">
    </div>
    
    @include('components.modalfooterdelete')
</div>
