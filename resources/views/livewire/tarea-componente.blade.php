<div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <h1>Tareas</h1>
                <div class="m-3 col-md-12 text-end">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalForm">Nuevo</button>
                </div>
                <div class="input-group my-3">
                    <input type="text" class="form-control" wire:model='criterio' name="criterio" placeholder="Buscar...">
                </div>

            <div class="row ">
            
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="" class="form-label">Estatus</label>
                        <select class="form-select form-select-lg" name="estatus" id="estatus"
                            wire:model='estatus'>
                            <option value=""></option>
                            @foreach ($estatuses as $estatus)
                                <option value="{{$estatus->id}}">{{$estatus->todo_estatus}}</option> 
                            @endforeach
                        </select>
                    </div>
                </div>
            
                <div class="col-md-3 mb-4 m-md-0">
                    <label for="" class="form-label">Tipo</label>
                    <select class="form-select form-select-lg" name="tipo" id="tipo"
                        wire:model='tipo'>
                        <option selected></option>
                            @foreach ($tipos as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->todo_tipo}}</option> 
                            @endforeach                        
                    </select>
                </div>
            
            </div>    

                <table class="table table-striped mt-md-1">
                    <thead>
                        <tr>
                            <th scope="col" class="d-none d-md-table-cell">N</th>
                            <th scope="col">Tarea</th>
                            <th scope="col">Cliente</th>
                            <th scope="col" class="d-none d-md-table-cell">Tipo</th>
                            <th scope="col">Estatus</th>
                            <th scope="col">Fec Limite</th>
                            <th scope="col" class="text-center">Acción</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($todos as $todo)
                        <tr>
                            <td scope="row" class="d-none d-md-table-cell">{{ $todo->id }}</td>
                            <td>{{ $todo->nombre }}</td>
                            <td>@if ($todo->cliente=='') Empresa @else {{ $todo->cliente }} @endif </td>
                            <td class="d-none d-md-table-cell">{{ $todo->todo_tipo }}</td>
                            <td>{{ $todo->todo_estatus }}</td>
                            <td>{{ $todo->fechaLimite }}</td>
                            <td>
                                <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-primary btn-sm btn-block m-1 rounded" wire:click='edit({{ $todo->id }})' data-toggle="modal" data-target="#modalForm">Editar</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-danger btn-sm btn-block m-1 rounded" wire:click='edit({{ $todo->id }})'  data-toggle="modal" data-target="#modalFormDelete">Eliminar</button>
                                        </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
    
                    </tbody>
                </table>
                {{ $todos->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    @include('components.modalheader')
    
    <div class="mb-3">


        <div class="form-group">
             <div>
                ID : {{$Id}}
            </div>           
            <div class="form-group">
                <label for="nombre">Tarea</label>
                <input type="text" class="form-control" wire:model.lazy="nombre" placeholder="tarea" required>
                @error('nombre') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" wire:model.lazy="descripcion" required rows="3"></textarea>
                @error('descripcion') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        
            <div class="form-group">
                <label for="Clientes">Tipo de Tarea</label>
                <select class="form-control form-control-sm" wire:model.lazy="todo_tipo">
                    <option selected>Tipo</option>
                    @foreach ($tipos as $tipo)
                    <option value="{{$tipo->id}}">{{ $tipo->todo_tipo }}</option>
                    @endforeach        
                </select>
                @error('todo_tipo') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="datetime-local" class="form-control"  placeholder="Fecha Limite" wire:model.lazy="fechaLimite" required >
                @error('fechaLimite') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        
            <div class="form-group">
                <label for="Clientes">Cliente</label>
                <select class="form-control form-control-sm" wire:model.lazy="cliente_id">
                    <option selected>Cliente</option>
                    @foreach ($clientes as $cliente)
                    <option value="{{$cliente->id}}">{{ $cliente->nombre }}</option>
                    @endforeach        
                </select>
                @error('cliente_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        
        
            <div class="form-group">
                <label for="Clientes">Estatus de la Tarea</label>
                <select class="form-control form-control-sm" wire:model.lazy="todo_estatus">
                    <option selected>Estatus</option>
                    @foreach ($estatuses as $estatus)
                    <option value="{{$estatus->id}}">{{ $estatus->todo_estatus }}</option>
                    @endforeach        
                </select>
                @error('todo_estatus') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        
        </div>
        
    </div>
    
    @include('components.modalfooter')
    
    @include('components.modalheaderdelete')
    
    <div class="mb-3">
        <label for="" class="form-label">Tarea</label>
        <input type="text" disabled class="form-control" wire:model.lazy='nombre'>
    </div>
    
    @include('components.modalfooterdelete')    
</div>
