<div>
    <div>
        <div class="card shadow">
            <div class="card-body pb-0">
                @if (session('status'))
                <div class="alert alert-success p-1">
                    {{ session('status') }}
                </div>
                @endif 
    
                <div class="col-12">
                    <button type="button" class="btn btn-primary " data-toggle="modal" wire:click='clear' data-target="#modalForm" >Nuevo</button>
                </div>
    
                <div class="row">
                    <div class="col-md-12 mb-3 ">
                        <div class="input-group my-3">
                            <input type="text" class="form-control" wire:model='criterio' name="criterio" placeholder="Buscar...">
                        </div> 
                    </div>            
                </div>
    
                <div class="row">
                
                    <div class="col-sm-12 col-md-3 mb-3 ">
                        <div class="form-group">
                            <label for="" class="form-label">Tipo {{ $tipo}}</label>
                            <select class="form-control" wire:model='tipo'>
                                <option value=""></option>
                                @foreach ($tipos as $tipo)

                                    <option value="{{$tipo->id}}">{{$tipo->todo_tipo}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                
                    <div class="col-sm-12 col-md-3 mb-3 ">
                        <div class="form-group">
                            <label for="" class="form-label">Estatus</label>
                            <select class="form-control" 
                                wire:model='estatus'>
                                <option value="" selected></option>
                                @foreach ($estatuses as $estatus)
                                    <option value="{{$estatus->id}}">{{ $estatus->todo_estatus }}</option>                                
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 mb-3 ">
                    <div class="form-group">
                        <label for="" class="form-label">Fecha Limite de Inicio</label>
                        <input type="date" class="form-control" wire:model='fecha_inicio' placeholder="Fecha" />
                    </div>
                    </div>
                    
                    <div class="col-sm-12 col-md-3 mb-3 ">
                    <div class="form-group">
                        <label for="" class="form-label">Fecha Limite de Fin</label>
                        <input type="date" class="form-control" wire:model='fecha_fin' placeholder="Fecha" />
                    </div>
                    </div>                     

                    
                
                </div>
    
            </div>
        </div>
     
             
        <div class="row">
        @if (isset($tareas))
          <div class="card shadow col-md-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="d-none d-md-table-cell">#</th>
                        <th>Tarea</th>
                        <th class="">Cliente</th>
                        <th class="">Tipo</th>
                        <th class="d-none d-sm-table-cell">Estatus</th>
                        <th class="d-none d-sm-table-cell">Fecha Limite</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>            

                    @forelse ($tareas as $tarea)

                    <tr>
                        <td class="d-none d-md-table-cell">{{ $tarea->id }}</td>
                        <td>{{ $tarea->nombre }}</td>
                        <td>{{ $tarea->cliente }}</td>
                        <td>{{ $tarea->todo_tipo }}</td>
                        <td class="d-none d-sm-table-cell">{{ $tarea->todo_estatus }}</td>
                        <td class="d-none d-sm-table-cell">{{ $tarea->fechaLimite }}</td>

                        <td class="text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn  btn-success" wire:click='edit({{ $tarea->id }})' data-toggle="modal"
                                    data-target="#modalForm">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                <button type="button" class="btn btn-danger" 
                                    wire:click="$emit('generarBorrarTareaProgamadaSweetAlert',{{ $tarea->id }}, 'Borrar Cliente ID ', 'borrarContacto')" data-element-id="{{ $tarea->id }}" 
                                    type="submit">
                                        <i class="fa fa-trash"></i>
                                </button>
                                <button type="button" class="btn btn-secondary" 
                                    wire:click="verTarea({{ $tarea->id }})" data-toggle="modal"
                                    data-target="#verTarea" data-element-id="{{ $tarea->id }}" 
                                    type="button">
                                        <i class="fa fa-eye"></i>
                                </button>                                
                              </div>
                        </td>

                    </tr>

                    @endforeach

                </tbody>
            </table>
            {{ $tareas->links() }}
        </div>
        @endif
        
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

        <!-- Modal -->
        <div class="modal fade" id="verTarea" wire:ignore.self  tabindex="-1" data-backdrop="static">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">ID : {{$Id}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <h5 class="text-bold text-primary">TAREA</h5>
                    <p>{{$nombre}}</p>
                    <h5 class="text-bold text-primary">DESCRIPCION</h5>
                    <p>{{$descripcion}}</p>
                    <h5 class="text-bold text-primary">TIPO</h5>
                    <p>{{$todo_tipo}}</p>
                    <h5 class="text-bold text-primary">FECHA LIMITE</h5>
                    <p>{{$fechaLimite}}</p>
                    <h5 class="text-bold text-primary">CLIENTE</h5>
                    <p>{{$cliente_nombre}}</p>
                    <h5 class="text-bold text-primary">ESTATUS</h5>
                    <p>{{$todo_estatus}}</p>


                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="clear">Close</button>
                </div>
            </div>
            </div>
        </div>

</div>
