<div>

    <div>
    

        {{-- <div class="col-md-12">
            <button type="button" class="btn btn-primary my-1 p-o"
                wire:click='clear' data-toggle="modal"
                data-target="#modalForm">Nueva</button>
        </div>     --}}
        
        <div class="card shadow p-2">
            <div class="m-0">
                <hr class="bg-primary m-0 h-100">
            </div>    
                <table class="table table-striped m-1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>Nombre</th>
                            <th class="d-none d-md-table-cell">Titulo</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inmobiliarias as $inmobiliaria)
                        <tr>
                            <td scope="row">{{ $inmobiliaria->id }}</td>
                            <td><img src="{{ asset('assets/'.$inmobiliaria->logo) }}" class="rounded zoom" height="80rem" width="100" alt=""></td>
                            <td>{{ $inmobiliaria->nombre }}</td>
                            <td class="d-none d-md-table-cell">{{ $inmobiliaria->titulo }}</td>

                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-secondary btn-success" wire:click='edit({{ $inmobiliaria->id }})' data-toggle="modal"
                                        data-target="#modalForm">
                                            <i class="fa fa-edit"></i>
                                    </button>
                                  </div>
                            </td>
                        </tr>
                        @endforeach
    
                    </tbody>
                </table>
                {{ $inmobiliarias->links("pagination::bootstrap-4") }}
        </div>
   
        @include('components.modalheader')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h1>INMOBILIARIA</h1>
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
                        @method("put")
                        @csrf
                        <div class="form-group">
        
                            <div class="form-group">
                                <label for="titulo">Nombre</label>
                                <input type="text" class="form-control" placeholder="nombre" wire:model.lazy='nombre'>
                            </div>
        
                            <div class="form-group">
                                <label for="titulo">Correo</label>
                                <input type="email" class="form-control"  placeholder="correo" wire:model.lazy='correo'>
                            </div>
                            
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control" placeholder="telefono" wire:model.lazy='telefono'>
                            </div>                    
        
                            <div class="form-group">
                                <label for="descripcion">Direccion</label>
                                <textarea class="form-control" id="direccion" name="direccion" rows="3" wire:model.lazy='direccion'></textarea>
                            </div>                                      
        
                            <div class="form-group">
                                <label for="titulo">Titulo</label>
                                <input type="text" class="form-control" placeholder="titulo" wire:model.lazy='titulo'>
                            </div>

                            <div class="form-group">
                                <label for="slogan">Slogan</label>
                                <input type="text" class="form-control" maxlength="255" placeholder="slogan" wire:model.lazy='slogan'>
                            </div>

                            <div class="form-group">
                                <label for="slogan">Palabras Claves</label>
                                <input type="text" class="form-control" maxlength="255" placeholder="palabras claves" wire:model.lazy='palabrasclaves'>
                            </div>                            
        
                            <div class="form-group" wire:ignore>
                                <label for="quienessomos">Quienes Somos</label>
                                <textarea class="form-control" wire:model.lazy='quienessomos' rows="3" id="quienessomos"></textarea>
                            </div>                    
                            
                            <div class="form-group">
                                <label for="descripcion">Meta Description</label>
                                <textarea class="form-control" wire:model.lazy='metadescription' rows="3"></textarea>
                            </div>
        
                            <div class="form-group">
                                <label for="facebook">Facebook</label>
                                <input type="text" class="form-control" placeholder="facebook" wire:model.lazy='facebook'>
                            </div>
                            
                            <div class="form-group">
                                <label for="instagram">Instagram</label>
                                <input type="text" class="form-control"  placeholder="instagram" wire:model.lazy='instagram'>
                            </div>
                            
                            <div class="form-group">
                                <label for="tiktok">Tiktok</label>
                                <input type="text" class="form-control" placeholder="tiktok" wire:model.lazy='tiktok'>
                            </div>
                            
                            <div class="form-group">
                                <label for="whatsapp">Whatsapp</label>
                                <input type="text" class="form-control" placeholder="whatsapp" wire:model.lazy='whatsapp'>
                            </div>     
                            
            
                            <div
                            x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                            >
                            <label for="formFile" class="form-label">Logo</label>
                            <div class="form-group custom-file">
                                <input type="file" class="custom-file-input" wire:model.lazy='logo'>
                                <label class="custom-file-label" for="customFile">Seleccione foto</label>
                                @error('logo') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            
                                <!-- Progress Bar -->
                                <div x-show="isUploading" class="m-2" >
                                    <div x-text="progress + '%'"></div>
                                    <progress min="1" max="100" x-bind:value="progress" style="height: 25px"></progress>
                                </div>
                            </div>  
                            
                            <div class="form-group">
                                @if($logo && !(is_string($logo)))
                                <img class="img-fluid img-thumbnail mt-4" width="300px" wire:model.lazy='logo' src="{{ $logo->temporaryUrl() }}">
                                <p class="text-left"><button type="button" class="btn btn-xs btn-danger m-1 " width="10px" wire:click='borrar_logo' ><i class="fa fa-trash"></i></button></p>        
                                @else
                                    @if ($logo)
                                    <img class="img-fluid img-thumbnail mt-4" width="300px" wire:model.lazy='logo' src="{{ asset('assets/'.$logo) }}">
                                    <p class="text-left"><button type="button" class="btn btn-xs btn-danger m-1 " width="10px" wire:click='borrar_logo' ><i class="fa fa-trash"></i></button></p>               
                                    @endif
                                
                                @endif
                            </div>                             
                             
                            <div
                            x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                            >
                            <label for="formFile" class="form-label">Favicon</label>
                            <div class="form-group custom-file">
                                <input type="file" class="custom-file-input" wire:model.lazy='favicon'>
                                <label class="custom-file-label" for="customFile">Seleccione foto</label>
                                @error('favicon') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            
                                <!-- Progress Bar -->
                                <div x-show="isUploading" class="m-2" >
                                    <div x-text="progress + '%'"></div>
                                    <progress min="1" max="100" x-bind:value="progress" style="height: 25px"></progress>
                                </div>
                            </div>  
                            
                            <div class="form-group">
                                @if($favicon && !(is_string($favicon)))
                                <img class="img-fluid img-thumbnail mt-4" width="300px" wire:model.lazy='favicon' src="{{ $favicon->temporaryUrl() }}">
                                <p class="text-left"><button type="button" class="btn btn-xs btn-danger m-1 " width="10px" wire:click='borrar_favicon' ><i class="fa fa-trash"></i></button></p>        
                                @else
                                    @if ($favicon)
                                    <img class="img-fluid img-thumbnail mt-4" width="300px" wire:model.lazy='favicon' src="{{ asset('assets/'.$favicon) }}">
                                    <p class="text-left"><button type="button" class="btn btn-xs btn-danger m-1" width="10px" wire:click='borrar_favicon' ><i class="fa fa-trash"></i></button></p>        
                                    @endif
    
                                @endif
                            </div>                                                
    
                            <div class="form-group">
                                <label for="imagenlogo">Publicaciones Necesitan Aprobación?</label>
                                <div class="">
                                    <label class="switch">
                                        <input class="form-check-input switch" type="checkbox" wire:model.lazy='aprobacion'
                                        @if ($aprobacion==1) checked @endif
                                        >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('components.modalfooter')

        <script> 
            window.AdminCkeditor?.ensure('#quienessomos', (value) => {
                @this.set('quienessomos', value);
            });
                
        </script>        

</div>

</div>