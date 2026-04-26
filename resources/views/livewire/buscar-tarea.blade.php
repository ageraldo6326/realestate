<div>
    @if (session('status'))
    <div class="alert alert-success p-1">
        {{ session('status') }}
    </div>
    @endif  

    <div class="col-md-12">
        <button type="button" class="btn btn-primary my-1 p-o"
            wire:click='clear' data-toggle="modal"
            data-target="#modalForm">Nueva</button>
    </div>    
    
    <div class="card shadow p-2">
        <div class="m-0">
            <hr class="bg-primary m-0 h-100">
        </div> 
        <input type="text" class="form-control mt-1 shadow " wire:model='criterio' placeholder="Escribir tarea" >     
        <div class="row">
    
            <div class="col-12 ">
        
                <table class="table table-striped m-1">
        
                    <div class="col-12 mb-1">
        
                        <thead>
                            <tr">
                                <th>#</th>
                                <th>Tarea</th>
                                <th class="text-center">Color</th>
                                <th>Creado en</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
        
                    </div>
        
                    <tbody class="m-2">
                        @foreach ( $tareas as $tarea)
                        <tr>
                            <th scope="row">{{ $tarea->id}}</th>
                            <td>{{ $tarea->todo_tipo}}</td>
                            <td class="w-25"><span class="card shadow w-100 text-center text-white"  style="background: {{ $tarea->color }}">{{ $tarea->color }}</span></td>
                            <td>{{ $tarea->created_at}}</td>

                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-secondary btn-success" wire:click='edit({{ $tarea->id }})' data-toggle="modal"
                                        data-target="#modalForm">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    <button type="button" class="btn btn-secondary btn-danger" 
                                        wire:click="$emit('generarBorrarTareaSweetAlert',{{ $tarea->id }})" data-element-id="{{ $tarea->id }}" 
                                        type="submit">
                                            <i class="fa fa-trash"></i>
                                    </button>
                                  </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $tareas->links() }}
            </div>

            @include('components.modalheader')
            <div class="container">
                <div class="row">
            
                    <div class="col-12">
            
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
            
                        <form>
            
                            <div class="form-group">
                                <label for="minititulo">Tarea</label>
                                <input type="text" class="form-control" wire:model.lazy='tarea' placeholder="Tarea" required maxlength="50">
                            </div>

                            <div class="form-group">
                                <label for="minititulo">Color</label>
                                <input type="color" class="form-control" wire:model.lazy='color' placeholder="Color" required maxlength="50">
                            </div>                            
                        
                        </form>
                    </div>
            
                </div>
            </div>            
            @include('components.modalfooter')             
        </div>               
    </div>
    
</div>
