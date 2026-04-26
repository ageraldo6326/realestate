<div>
<style>
    .catalog-shell { display: grid; gap: 1rem; }
    .catalog-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
        border-radius: 1.25rem;
        color: #fff;
        padding: 1.5rem;
        box-shadow: 0 20px 45px rgba(15,23,42,.18);
    }
    .catalog-panel {
        border: 1px solid #dbe4f0;
        border-radius: 1.25rem;
        box-shadow: 0 14px 28px rgba(15,23,42,.06);
    }
    .status-badge {
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .04em;
        padding: .25rem .6rem;
        border-radius: 999px;
        white-space: nowrap;
    }
</style>

@if (session('status'))
    <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">{{ session('status') }}</div>
@endif

<div class="catalog-shell">

    {{-- Hero --}}
    <section class="catalog-hero">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h4 mb-1 font-weight-bold">Contactos</h2>
                <p class="mb-0 text-white-50">Listado de todos los contactos y clientes potenciales del CRM.</p>
            </div>
            <button type="button" class="btn btn-light btn-sm px-3" data-toggle="modal" wire:click='clear2'
                data-target="#modalForm">
                <i class="fas fa-plus mr-1"></i> Nuevo
            </button>
        </div>
    </section>

    {{-- Panel principal --}}
    <section class="card catalog-panel">
        <div class="card-body p-4">

            {{-- Barra de búsqueda y filtros --}}
            <div class="row mb-4 align-items-end">
                <div class="col-lg-4 mb-2 mb-lg-0">
                    <label class="small text-muted font-weight-semibold">Buscar</label>
                    <input type="text" class="form-control form-control-lg rounded-lg"
                        wire:model.debounce.350ms="criterio" placeholder="Nombre, teléfono, email...">
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                    <label class="small text-muted font-weight-semibold">Estatus</label>
                    <select class="form-control form-control-sm rounded-lg" wire:model='criterioestatus'>
                        <option value="">Todos</option>
                        <option value="NUEVO">NUEVO</option>
                        <option value="CONTACTADO">CONTACTADO</option>
                        <option value="ACTIVO">ACTIVO</option>
                        <option value="FUTURO">FUTURO</option>
                        <option value="CIERRE">CIERRE</option>
                        <option value="DESCARTADO">DESCARTADO</option>
                        <option value="NOESCLIENTE">NO ES CLIENTE POTENCIAL</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                    <label class="small text-muted font-weight-semibold">Probabilidades</label>
                    <select class="form-control form-control-sm rounded-lg" wire:model='criterioprobabilidades'>
                        <option value="">Todas</option>
                        <option value="BAJAS">BAJAS</option>
                        <option value="MEDIAS">MEDIAS</option>
                        <option value="ALTAS">ALTAS</option>
                        <option value="DESCONOCIDA">DESCONOCIDA</option>
                    </select>
                </div>
            </div>

            {{-- Tabla --}}
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="text-uppercase small text-muted">
                        <tr>
                            <th style="width:50px;">ID</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Estatus</th>
                            <th>Probabilidades</th>
                            <th>Captado por</th>
                            <th>Asignado a</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientes as $cliente)
                            @php
                                $statusColors = [
                                    'NUEVO'      => 'background:#fef3c7;color:#92400e;',
                                    'CONTACTADO' => 'background:#dbeafe;color:#1d4ed8;',
                                    'ACTIVO'     => 'background:#dcfce7;color:#166534;',
                                    'FUTURO'     => 'background:#f3f4f6;color:#374151;',
                                    'CIERRE'     => 'background:#d1fae5;color:#065f46;',
                                    'DESCARTADO' => 'background:#fee2e2;color:#991b1b;',
                                    'NOESCLIENTE'=> 'background:#f3f4f6;color:#6b7280;',
                                ];
                                $probStars = [
                                    'BAJAS'       => 1,
                                    'MEDIAS'      => 3,
                                    'ALTAS'       => 5,
                                    'DESCONOCIDA' => 0,
                                ];
                                $estStyle = $statusColors[$cliente->estatus] ?? 'background:#f3f4f6;color:#374151;';
                                $stars = $probStars[$cliente->probabilidades] ?? 0;
                            @endphp
                            <tr>
                                <td class="font-weight-semibold text-muted">{{ $cliente->id }}</td>
                                <td>
                                    <div class="font-weight-600">{{ $cliente->nombre }}</div>
                                    <small class="text-muted">{{ $cliente->email }}</small>
                                </td>
                                <td class="text-muted small">{{ $cliente->telefono }}</td>
                                <td>
                                    <span class="status-badge" style="{{ $estStyle }}">
                                        {{ $cliente->estatus }}
                                    </span>
                                </td>
                                <td>
                                    @if($stars > 0)
                                        @for($s = 1; $s <= 5; $s++)
                                            <i class="fas fa-star{{ $s <= $stars ? '' : '-o' }}"
                                               style="color:{{ $s <= $stars ? '#f59e0b' : '#d1d5db' }};font-size:.7rem;"></i>
                                        @endfor
                                        <span class="small text-muted ml-1">{{ $cliente->probabilidades }}</span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td class="small text-muted">{{ optional($cliente->user)->name ?? optional($cliente->user)->email ?? '—' }}</td>
                                <td class="small text-muted">{{ optional($cliente->user2)->name ?? optional($cliente->user2)->email ?? '—' }}</td>
                                <td class="text-right">
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                        wire:click="edit({{ $cliente->id }})"
                                        data-toggle="modal" data-target="#modalForm">
                                        Ver
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">No hay contactos para mostrar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $clientes->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </section>
</div>

@include('components.modalheader')



<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">

            <div class="mb-3">
                <form wire:submit.prevent="submit">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Captado por:</label>
                                {{ $cliente->user->email }}
                            </div>
                        </div>      
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Asignado a:</label>
                                {{ $cliente->user2->email }}
                            </div>
                        </div>                         
                     

                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="titulo">Titulo</label>
                                <select class="form-control" name="titulo" id="titulo" required
                                    wire:model.lazy="titulo">
                                    <option value="">Titulo</option>
                                    <option value="Señor">Señor</option>
                                    <option value="Señora">Señora</option>
                                    <option value="Señorita">Señorita</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="nombre">* Nombre</label>
                                <input type="text" wire:model.lazy="nombre" id="nombre" name="nombre" required
                                    class="form-control">
                                @error('nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tipo_contacto">* Tipo Contacto</label>
                                <select class="form-control" name="tipo_contacto" id="tipo_contacto"
                                    wire:model.lazy="tipo_contacto" required>
                                    <option value="">Tipo</option>
                                    <option value="PersonaFisica">Persona Fisica</option>
                                    <option value="Empresa">Empresa</option>
                                </select>
                                @error('tipo_contacto') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="telefono">* Telefono</label>
                                <input type="number" required class="form-control" wire:model.lazy="telefono" @if ($Id>0) disabled @endif wire:change="verificarContacto()" >
                                @error('telefono') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="email"
                                    wire:model.lazy="email">
                            </div>
                        </div>
                        @if (session('TelefonoDuplicado'))
                        <div class="alert alert-danger">
                            {{ session('TelefonoDuplicado') }}
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">* Comentario</label>
                        <textarea class="form-control" name="comentario" id="comentario" rows="3"
                            wire:model.lazy="comentario"></textarea>
                        @error('comentario') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="row">

                        <div class="form-group col-md-4">
                            <label for="contact_at">* Fecha de Contacto</label>
                            <input type="date" class="form-control" required id="contact_at" name="contact_at"
                                wire:model.lazy="contact_at">
                            @error('contact_at') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="contact_at">* Estatus
                                @if ($estatus=="NUEVO")
                                <span class="fa fa-handshake text-warning mx-1"></span>
                                @endif
                                @if ($estatus=="CONTACTADO")
                                <span class="fa fa-comments text-info mx-1"></span>
                                @endif
                                @if ($estatus=="ACTIVO")
                                <span class="fa fa-people-carry text text-danger mx-1"></span>
                                @endif
                                @if ($estatus=="CIERRE")
                                <span class="fa fa-check-double text text-success mx-1"></span>
                                @endif
                                @if ($estatus=="FUTURO")
                                <span class="fa fa-business-time text text-dark mx-1"></span>
                                @endif
                                @if ($estatus=="DESCARTADO")
                                <span class="fa fa-ban text text-muted mx-1"></span>
                                @endif
                                @if ($estatus=="NOESCLIENTE")
                                <span class="fa fa-users text text-dark mx-1"></span>
                                @endif
                            </label>
                            <select class="form-select" aria-label="Default select example" name="estatus" id="estatus"
                                wire:model.lazy="estatus">
                                <option></option>
                                <option @if($Id=="" ) selected @else required @endif value="NUEVO">NUEVO</option>
                                <option value="CONTACTADO">CONTACTADO</option>
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="FUTURO">FUTURO</option>
                                <option value="CIERRE">CIERRE</option>
                                <option value="DESCARTADO">DESCARTADO</option>
                                <option value="NOESCLIENTE">NO ES CLIENTE POTENCIAL</option>
                            </select>
                            @error('estatus') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group col-4">
                            <label for="contact_at">Probabilidades
                                @if ($probabilidades=="BAJAS")
                                <span class="fa fa-star text-warning mx-1">
                                    @endif

                                    @if ($probabilidades=="MEDIAS")
                                    <span class="fa fa-star text-warning mx-1">
                                        <span class="fa fa-star text-warning mx-1">
                                            <span class="fa fa-star text-warning mx-1">
                                                @endif

                                                @if ($probabilidades=="ALTAS")
                                                <span class="fa fa-star text-warning mx-0">
                                                    <span class="fa fa-star text-warning mx-0">
                                                        <span class="fa fa-star text-warning mx-0">
                                                            <span class="fa fa-star text-warning mx-0">
                                                                <span class="fa fa-star text-warning mx-0">
                                                                    @endif
                            </label>
                            <select class="form-select" aria-label="Default select example" name="probabilidades"
                                id="probabilidades" wire:model.lazy="probabilidades">
                                <option selected></option>
                                <option value="BAJAS">BAJAS</option>
                                <option value="MEDIAS">MEDIAS</option>
                                <option value="ALTAS">ALTAS</option>
                                <option value="DESCONOCIDA">DESCONOCIDA</option>
                            </select>
                            @error('estatus') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">

                        <div class="col-md-4 m-1">
                            <input clase="form-control" type="checkbox" wire:model.lazy="activo">
                            <label for="activo">Activo?</label>
                        </div>

                        <div class="col-md-4">
                            <label for="fecha">Fecha del cierre:</label>
                            <input type="date" id="fechacierre" wire:model.lazy="fechacierre" name="fechacierre"
                                class="form-control">
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_contacto2">* Tipo Contacto</label>
                                <select class="form-control" name="tipo_contacto2" id="tipo_contacto2" required
                                    wire:model.lazy="tipo_contacto2">
                                    <option value="">Tipo</option>
                                    <option value="Vendedor">Vendedor</option>
                                    <option value="Comprador">Comprador</option>
                                    <option value="Inquilino">Inquilino</option>
                                </select>
                                @error('tipo_contacto2') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medio">* Por donde supo de nosotros</label>
                                <select class="form-control" name="medio" id="medio" required wire:model.lazy="medio">
                                    <option value="">Tipo</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="Letrero">Letrero</option>
                                    <option value="Radio">Radio</option>
                                    <option value="TV">TV</option>
                                    <option value="Referido">Referido</option>
                                    <option value="Otro">Otro</option>
                                </select>
                                @error('medio') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- <div class="form-group">
                        <label for="" class="form-label">Testimonio</label>
                        <textarea class="form-control" name="testimonio" id="testimonio" rows="3"
                            wire:model.lazy="testimonio"></textarea>
                    </div> --}}

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h3 class="text-bold text-primary">NEGOCIO</h3>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="Zona">Zona</label>
                                        <select class="form-control" name="zona_id" id="zona_id"
                                            wire:model.lazy="zona_id">
                                            <option selected>Zona</option>
                                            @foreach ($zonas as $zona)
                                            <option value="{{$zona->id}}">{{ $zona->zona }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tipo">Tipo</label>
                                            <select class="form-control" name="tipo" id="tipo" wire:model.lazy="tipo">
                                                <option selected>Tipo</option>
                                                @foreach ($tipos_propiedades as $tipos_propiedad)
                                                <option value="{{ $tipos_propiedad->id}}">{{ $tipos_propiedad->tipo }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="estadopropiedad">Estado</label>
                                            <select class="form-control" name="estadopropiedad" id="estadopropiedad"
                                                wire:model.lazy="estadopropiedad">
                                                <option selected>Estado Propiedad</option>
                                                @forelse ($estados_propiedad as $estado_propiedad )
                                                <option value="{{ $estado_propiedad->id }}">{{
                                                    $estado_propiedad->estado }}</option>
                                                @empty

                                                @endforelse
                                            </select>
                                        </div>
                                    </div>                                

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="precio_mini">Precio Min RD$</label>
                                            <input type="text" class="form-control monto" id="precio_mini"
                                                name="precio_mini" placeholder="Precio" wire:model.lazy="precio_mini">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="precio_max">Precio Max RD$</label>
                                            <input type="text" class="form-control monto" id="precio_max"
                                                name="precio_max" placeholder="Precio" wire:model.lazy="precio_max">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tipo_en_dolar">Tipo US$</label>
                                            <select class="form-control" name="tipo_en_dolar" id="tipo_en_dolar"
                                                wire:model.lazy="tipo_en_dolares">
                                                <option selected>Tipo</option>
                                                @foreach ($tipos_propiedades as $tipos_propiedad)
                                                <option value="{{ $tipos_propiedad->id}}">{{ $tipos_propiedad->tipo }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="estadopropiedad_en_dolar">Estado US$</label>
                                            <select class="form-control" name="estadopropiedad_en_dolar"
                                                id="estadopropiedad_en_dolar"
                                                wire:model.lazy="estadopropiedad_en_dolar">
                                                <option selected>Estado Propiedad</option>
                                                @forelse ($estados_propiedad as $estado_propiedad )
                                                <option value="{{ $estado_propiedad->id }}">{{
                                                    $estado_propiedad->estado }}</option>
                                                @empty

                                                @endforelse
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="precio">Precio Min US$</label>
                                            <input type="text" class="form-control monto" id="precio_mini_dolar"
                                                name="precio_mini_dolar" placeholder="Precio"
                                                wire:model.lazy="precio_mini_dolar">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="precio">Precio Max US$</label>
                                            <input type="text" class="form-control monto" id="precio_max_dolar"
                                                name="precio_max_dolar" placeholder="Precio"
                                                wire:model.lazy="precio_max_dolar">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="habitaciones">Hab</label>
                                            <select class="form-control" name="habitaciones" id="habitaciones"
                                                wire:model.lazy="habitaciones">
                                                <option selected>Habitaciones</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="habitaciones">Parqueos</label>
                                            <select class="form-control" name="parqueos" id="parqueos"
                                                wire:model.lazy="parqueos">
                                                <option selected>Parqueos</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="habitaciones">Captadas Por</label>
                                            <select class="form-control" name="captadas_por" id="captadas_por"
                                                wire:model.lazy="captadas_por">
                                                <option value="todos">TODOS</option>
                                                <option value="mi">USUARIO</option>
                                            </select>
                                        </div>
                                    </div>




                                    @if ($Id>0)
                                    <div class="button-group">
                                        <button class="btn btn-primary mb-2"
                                            wire:click.prevent="updatePropuesta({{$Id}})">Crear propuesta</button>
                                    </div>
                                    @endif
                                </div>


                                @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif

                                @if (session('duplicado'))
                                <div class="alert alert-danger">
                                    {{ session('duplicado') }}
                                </div>
                                @endif
                                <div class="modal-footer">
                                    <form>
                                        <button type="button" class="btn btn-primary close-modal" @if($grabar==0) hidden
                                            @endif @if($Id==0) wire:click.prevent='store' @else
                                            wire:click.prevent='update({{$Id}})' @endif> @if($Id==0) Grabar @else
                                            Actualizar @endif </button>
                                        @if($Id==0)
                                        <button type="button" class="btn btn-warning"
                                            wire:click='clear'>Cancelar</button>
                                        @endif
                                        <button type="button" class="btn btn-info close-modal text-white"
                                            wire:click="limpiar_tarea()" wire:click='salir()'
                                            data-bs-dismiss="modal">Salir</button>
                                        @if($Id!=0)
                                        <button type="button" class="btn btn-danger"
                                            wire:click="borrarConfirmacion({{$telefono}})">Borrar</button>
                                        @endif
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>



                </form>
            </div>

            <div x-data="{open : @entangle('open'), nota:@entangle('nota')}">
                @if ($Id>0)
                <a class="btn btn-primary" @click="[open = ! open, nota= '']" x-show="! open"><span
                        class="fa fa-plus text text-white mr-2"></span>Agregar nota</a>
                @endif

                <div class="row" x-show="open">
                    <div class="mb-3">
                        <label for="" class="form-label">Notas</label>
                        <textarea class="form-control" name="nota" id="nota" rows="3" wire:model="nota"></textarea>
                        @error('nota') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="row justify-content-end" x-show="open">
                    <div class="col-md-3">
                        <a class="btn btn-success btn-block m-1 p-1" @click="[nota ='']" wire:click='agregarnota'
                            role="button">Grabar</a>
                    </div>
                    <div class="col-md-3">
                        <a class="btn btn-danger btn-block m-1 p-1" @click="[open = ! open, nota ='']" href="#"
                            role="button">Cancelar</a>
                    </div>
                </div>
            </div>

            <div>
                @if (session('notaagregada'))
                @if(session('notaagregada')!='')
                <div class="alert alert-success">
                    {{ session('notaagregada') }}
                </div>
                @endif
                @endif

                @if (session('borrarnota'))
                @if(session('borrarnota')!='')
                <div class="alert alert-danger">
                    {{ session('borrarnota') }}
                </div>
                @endif
                @endif
            </div>

            <section style="background-color: #f7f6f6;">
                <div class="container my-1 py-1 text-dark">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="text-dark mb-0">Historial</h4>

                            </div>

                            @forelse ($notas as $nota)

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex flex-start">
                                        <img class="rounded-circle shadow-1-strong me-3" src="{{Auth::user()->foto}}"
                                            alt="avatar" width="40" height="40" />
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="text-primary fw-bold mb-0">
                                                    <span class="text-dark ms-2">{{$nota->nota}}
                                                    </span>
                                                </h6>
                                                <p class="mb-0"></p>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="small mb-0" style="color: #aaa;">
                                                    <a href="#!" class="link-grey"
                                                        wire:click="borrarnota({{$nota->id}})">Borrar</a>
                                                    •
                                                </p>
                                                <div class="d-flex flex-row">
                                                    <i class="fas" style="color: #aaa;">{{$nota->created_at}}</i>
                                                    <i class="far fa-star mx-2" style="color: #aaa;"></i>
                                                    <i class="far fa-check-circle text-primary"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @empty

                            @endforelse

                        </div>
                    </div>
            </section>

        </div>
        <div class="col-md-6">
            {{-- Inicio --}}

            <div x-data="{
                            open : @entangle('open'), 
                            nota : @entangle('nota')
                        }">
                @if ($Id>0)
                <a class="btn btn-primary" @click="[open = ! open, nota= '']" x-show="! open"
                    x-on:actualizar-valor.window="open = $event.detail"><span
                        class="fa fa-plus text text-white mr-2"></span>Agregar tarea</a>
                @endif
                {{-- Valor Open alpine:<span x-text="open"></span> --}}
                <div class="row" x-show="open">
                    <div class="mb-3">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="nombre">Titulo de Tarea @if($id_tarea!="") ID:{{$id_tarea}} @endif</label>
                                <input type="text" class="form-control" wire:model.lazy="nombre_tarea"
                                    placeholder="tarea" required>
                                @error('nombre_tarea') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control" wire:model.lazy="descripcion_tarea" required
                                    rows="3"></textarea>
                                @error('descripcion_tarea') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>



                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Clientes">Tipo de Tarea</label>
                                        <select class="form-control form-control-sm" wire:model.lazy="tipo_tarea">
                                            <option selected>Tipo</option>
                                            @foreach ($tipos as $tipo)
                                            <option value="{{$tipo->id}}">{{ $tipo->todo_tipo }}</option>
                                            @endforeach
                                        </select>
                                        @error('tipo_tarea') <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fecha">Fecha*</label>
                                        <input type="datetime-local" class="form-control" placeholder="Fecha Limite"
                                            wire:model.lazy="fecha_tarea" required>
                                        @error('fecha_tarea') <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Clientes">Estatus de la Tarea</label>
                                        <select class="form-control form-control-sm" wire:model.lazy="estatus_tarea">
                                            <option selected>Estatus</option>
                                            @foreach ($estatuses as $estatus)
                                            <option value="{{$estatus->id}}">{{ $estatus->todo_estatus }}</option>
                                            @endforeach
                                        </select>
                                        @error('estatus_tarea') <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>



                        </div>


                    </div>
                </div>

                <div>
                    @if (session('agregartarea'))
                    @if(session('agregartarea')!='')
                    <div class="alert alert-success">
                        {{ session('agregartarea') }}
                    </div>
                    @endif
                    @endif

                    @if (session('actualizartarea'))
                    @if(session('actualizartarea')!='')
                    <div class="alert alert-warning">
                        {{ session('actualizartarea') }}
                    </div>
                    @endif
                    @endif

                    @if (session('editartarea'))
                    @if(session('editartarea')!='')
                    <div class="alert alert-info">
                        {{ session('editartarea') }}
                    </div>
                    @endif
                    @endif

                    @if (session('borrartarea'))
                    @if(session('borrartarea')!='')
                    <div class="alert alert-danger">
                        {{ session('borrartarea') }}
                    </div>
                    @endif
                    @endif
                </div>

                <div class="row justify-content-end" x-show="open">
                    <div class="col-md-3">
                        <a class="btn btn-success btn-block m-1 p-1" @click="open = ! open" @if($id_tarea=="" )
                            wire:click='agregartarea' @else wire:click='actualizartarea({{$id_tarea}})' @endif
                            role="button">@if($id_tarea=="") Grabar @else Actualizar @endif</a>
                    </div>
                    <div class="col-md-3">
                        <a class="btn btn-danger btn-block m-1 p-1" href="#" wire:click="limpiar_tarea()"
                            @click="open = ! open" role="button">Cancelar</a>
                    </div>
                </div>
            </div>



            {{-- fin --}}

            <section style="background-color: #f7f6f6;">
                <div class="container my-1 py-1 text-dark">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="text-dark mb-0">Tareas</h4>
                            </div>

                            @forelse ($tareas as $tarea)

                            <div class="card text-dark bg-white mb-3" style="max-width: 100%;">
                                <div class="card-header fw-bold">{{$tarea->nombre}}</div>
                                <div class="card-body">
                                    <h5 class="card-title">{{$tarea->fechaLimite}}</h5>
                                    <p class="card-text">{{$tarea->descripcion}}</p>
                                    <div class="container">
                                        <div class="row justify-content-end">
                                            <div class="col-md-2 m-1">
                                                <a href="#" class="btn btn-warning btn-block"
                                                    @click="$dispatch('actualizar-valor', 'true')"
                                                    wire:click="editartarea({{$tarea->id}})">Editar</a>
                                            </div>
                                            <div class="col-md-2 m-1">
                                                <a href="#" class="btn btn-danger btn-block"
                                                    wire:click="borrartarea({{$tarea->id}})">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @empty

                            @endforelse

                        </div>
                    </div>
                </div>
            </section>

        </div>


        {{-- fin segunda columna --}}

    </div>
</div>

@include('components.modalfootercliente')

@include('components.modalheaderdelete')

<div class="mb-3">
    <label for="" class="form-label">Zona</label>
    <input type="text" disabled class="form-control" wire:model.lazy='zonaName' aria-describedby="helpId"
        placeholder="zona">
</div>

@include('components.modalfooterdelete')


</div>
