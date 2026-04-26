<div>
<div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="form-group">
                                <label for="id">Buscar Propiedad</label>
                                <input type="text" class="form-control" wire:model='criterio' name="criterio"
                                    placeholder="Buscar por ID, titulo o zona">
                                @if ($criterio!="")
                                <table class="table mt-0 rounded border table-hover">
                    
                                    <div class="col-12 shadow-lg mb-1 bg-white">
                    
                                        <thead class="bg-info">
                                            <tr class="border-0 text-white font-weight-bold rounded-circle">
                                                <th scope="col">Referencia</th>
                                                <th scope="col" class="text-left">Foto</th>
                                                <th scope="col">Titulo</th>
                                            </tr>
                                        </thead>
                    
                                    </div>
                    
                                    <tbody>
                    
                                        @foreach ( $propiedades as $propiedad)
                                        <tr>
                                            <th scope="row" class="text-sm">{{ $propiedad->referencia}}</th>
                                            <td><img src="{{ $propiedad->foto_portada}}" class="img-thumbnail " height="=200" width="200"
                                                    alt=""></td>
                                            <td class="text-sm">{{ $propiedad->titulo}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>    
</div>