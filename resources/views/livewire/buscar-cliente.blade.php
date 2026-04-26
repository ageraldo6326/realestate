<div>
    <style>
        .clientes-shell {
            display: grid;
            gap: 1rem;
        }

        .clientes-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, .06);
        }

        .clientes-panel .table thead th {
            border-top: none;
            border-bottom: 2px solid #e9ecef;
            font-size: .72rem;
            letter-spacing: .06em;
        }

        .clientes-panel .table tbody tr:hover {
            background: #f8fafc;
        }

        .badge-nuevo {
            background: #ffc107;
            color: #212529;
        }

        .badge-contactado {
            background: #17a2b8;
            color: #fff;
        }

        .badge-activo {
            background: #28a745;
            color: #fff;
        }

        .badge-cierre {
            background: #007bff;
            color: #fff;
        }

        .badge-futuro {
            background: #343a40;
            color: #fff;
        }

        .badge-descartado {
            background: #6c757d;
            color: #fff;
        }

        .badge-noescliente {
            background: #e9ecef;
            color: #495057;
        }

        .badge-bajas {
            background: #ffc107;
            color: #212529;
        }

        .badge-medias {
            background: #0dcaf0;
            color: #212529;
        }

        .badge-altas {
            background: #28a745;
            color: #fff;
        }
    </style>

    <div class="clientes-shell">

        {{-- Panel de búsqueda y filtros --}}
        <section class="card clientes-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Buscar contactos</h3>
                        <p class="text-muted mb-0 small">Filtra por nombre, estatus o probabilidad de cierre.</p>
                    </div>
                    <a href="{{ route('clientes.create') }}" class="btn btn-primary mt-3 mt-lg-0 px-4">
                        <i class="fas fa-plus mr-1"></i> Nuevo contacto
                    </a>
                </div>

                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label class="small text-muted font-weight-semibold">Buscar</label>
                        <input type="search" class="form-control form-control-lg rounded-lg"
                            wire:model.debounce.350ms="criterio" placeholder="Nombre, teléfono o correo..."
                            autocomplete="off" autocorrect="off" spellcheck="false">
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label class="small text-muted font-weight-semibold">Estatus</label>
                        <select class="form-control form-control-lg rounded-lg" wire:model="criterioestatus">
                            <option value="">Todos</option>
                            <option value="NUEVO">Nuevo</option>
                            <option value="CONTACTADO">Contactado</option>
                            <option value="ACTIVO">Activo</option>
                            <option value="FUTURO">Futuro</option>
                            <option value="CIERRE">Cierre</option>
                            <option value="DESCARTADO">Descartado</option>
                            <option value="NOESCLIENTE">No es cliente</option>
                        </select>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label class="small text-muted font-weight-semibold">Probabilidad</label>
                        <select class="form-control form-control-lg rounded-lg" wire:model="criterioprobabilidades">
                            <option value="">Todas</option>
                            <option value="BAJAS">Bajas</option>
                            <option value="MEDIAS">Medias</option>
                            <option value="ALTAS">Altas</option>
                            <option value="DESCONOCIDA">Desconocida</option>
                        </select>
                    </div>
                </div>
            </div>
        </section>

        {{-- Panel de listado --}}
        <section class="card clientes-panel">
            <div class="card-body p-4">

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-uppercase small text-muted">
                            <tr>
                                <th>Contacto</th>
                                <th class="d-none d-md-table-cell">Teléfono</th>
                                <th>Estatus</th>
                                <th class="d-none d-lg-table-cell">Probabilidad</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clientes as $cliente)
                                @php
                                    $statusClass = match ($cliente->estatus) {
                                        'NUEVO' => 'badge-nuevo',
                                        'CONTACTADO' => 'badge-contactado',
                                        'ACTIVO' => 'badge-activo',
                                        'CIERRE' => 'badge-cierre',
                                        'FUTURO' => 'badge-futuro',
                                        'DESCARTADO' => 'badge-descartado',
                                        default => 'badge-noescliente',
                                    };
                                    $probClass = match ($cliente->probabilidades) {
                                        'BAJAS' => 'badge-bajas',
                                        'MEDIAS' => 'badge-medias',
                                        'ALTAS' => 'badge-altas',
                                        default => 'badge-secondary',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <div class="font-weight-bold">{{ $cliente->nombre }}</div>
                                        <div class="small text-muted">{{ $cliente->email ?: 'Sin correo' }}</div>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <span class="text-muted">{{ $cliente->telefono ?: '—' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill {{ $statusClass }} px-2 py-1">
                                            {{ $cliente->estatus }}
                                        </span>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        @if ($cliente->probabilidades)
                                            <span class="badge badge-pill {{ $probClass }} px-2 py-1">
                                                {{ $cliente->probabilidades }}
                                            </span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-outline-primary btn-sm mr-1"
                                                wire:click="edit({{ $cliente->id }})" data-toggle="modal"
                                                data-target="#modalForm">
                                                Editar
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                wire:click="$emit('generarBorrarSweetAlert', {{ $cliente->id }}, 'Borrar Cliente ID ', 'borrarContacto')"
                                                data-element-id="{{ $cliente->id }}">
                                                Borrar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        No hay contactos para mostrar con el criterio actual.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $clientes->links() }}
                </div>
            </div>
        </section>

    </div>

    <div>

        @include('components.modalheader')

        <div class="row card card-body shadow">
            <div class="col-md-12">

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
                            @error('nombre')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
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
                            @error('tipo_contacto')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="telefono">* Telefono</label>
                            <input type="number" required class="form-control" wire:model.lazy="telefono"
                                @if ($Id > 0) disabled @endif wire:change="verificarContacto()">
                            @error('telefono')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="email" wire:model.lazy="email">
                        </div>
                    </div>
                    @if (session('TelefonoDuplicado'))
                        <div class="alert alert-danger">
                            {{ session('TelefonoDuplicado') }}
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="" class="form-label">* Comentario</label>
                        <textarea class="form-control" name="comentario" id="comentario" rows="3" wire:model.lazy="comentario"></textarea>
                        @error('comentario')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="contact_at">* Fecha de Contacto</label>
                        <input type="date" class="form-control" required id="contact_at" name="contact_at"
                            wire:model.lazy="contact_at">
                        @error('contact_at')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="contact_at">* Estatus
                            @if ($estatus == 'NUEVO')
                                <span class="fa fa-handshake text-warning mx-1"></span>
                            @endif
                            @if ($estatus == 'CONTACTADO')
                                <span class="fa fa-comments text-info mx-1"></span>
                            @endif
                            @if ($estatus == 'ACTIVO')
                                <span class="fa fa-people-carry text text-danger mx-1"></span>
                            @endif
                            @if ($estatus == 'CIERRE')
                                <span class="fa fa-check-double text text-success mx-1"></span>
                            @endif
                            @if ($estatus == 'FUTURO')
                                <span class="fa fa-business-time text text-dark mx-1"></span>
                            @endif
                            @if ($estatus == 'DESCARTADO')
                                <span class="fa fa-ban text text-muted mx-1"></span>
                            @endif
                            @if ($estatus == 'NOESCLIENTE')
                                <span class="fa fa-users text text-dark mx-1"></span>
                            @endif
                        </label>
                        <select class="form-control" aria-label="Default select example" name="estatus"
                            id="estatus" wire:model.lazy="estatus">
                            <option></option>
                            <option @if ($Id == '') selected @else required @endif value="NUEVO">
                                NUEVO</option>
                            <option value="CONTACTADO">CONTACTADO</option>
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="FUTURO">FUTURO</option>
                            <option value="CIERRE">CIERRE</option>
                            <option value="DESCARTADO">DESCARTADO</option>
                            <option value="NOESCLIENTE">NO ES CLIENTE POTENCIAL</option>
                        </select>
                        @error('estatus')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="contact_at">Probabilidades
                            @if ($probabilidades == 'BAJAS')
                                <span class="fa fa-star text-warning mx-1">
                            @endif

                            @if ($probabilidades == 'MEDIAS')
                                <span class="fa fa-star text-warning mx-1">
                                    <span class="fa fa-star text-warning mx-1">
                                        <span class="fa fa-star text-warning mx-1">
                            @endif

                            @if ($probabilidades == 'ALTAS')
                                <span class="fa fa-star text-warning mx-0">
                                    <span class="fa fa-star text-warning mx-0">
                                        <span class="fa fa-star text-warning mx-0">
                                            <span class="fa fa-star text-warning mx-0">
                                                <span class="fa fa-star text-warning mx-0">
                            @endif
                        </label>
                        <select class="form-control" name="probabilidades" id="probabilidades"
                            wire:model.lazy="probabilidades">
                            <option selected></option>
                            <option value="BAJAS">BAJAS</option>
                            <option value="MEDIAS">MEDIAS</option>
                            <option value="ALTAS">ALTAS</option>
                            <option value="DESCONOCIDA">DESCONOCIDA</option>
                        </select>
                        @error('estatus')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
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
                            @error('tipo_contacto2')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="medio">* Por donde supo de nosotros</label>
                            <select class="form-control" name="medio" id="medio" required
                                wire:model.lazy="medio">
                                <option value="">Tipo</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Instagram">Instagram</option>
                                <option value="Letrero">Letrero</option>
                                <option value="Radio">Radio</option>
                                <option value="TV">TV</option>
                                <option value="Referido">Referido</option>
                                <option value="Otro">Otro</option>
                            </select>
                            @error('medio')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="fecha">Fecha del cierre:</label>
                        <input type="date" id="fechacierre" wire:model.lazy="fechacierre" name="fechacierre"
                            class="form-control">
                    </div>

                    <div class="custom-control custom-checkbox col-md-4 my-auto">
                        <input type="checkbox" class="custom-control-input" id="activo" wire:model.lazy="activo">
                        <label class="custom-control-label" for="activo">Cliente Activo?</label>
                    </div>

                </div>

            </div>
        </div>


        <div class="row card card-body shadow">
            <div class="col-md-12">
                <div class="row col-md-12">
                    <h3 class="text-bold text-primary">QUE DESEA EL CLIENTE?</h3>
                </div>

                <div class="row">
                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="zona_id">Zona</label>
                            <select class="form-control" name="zona_id" id="zona_id" wire:model.lazy="zona_id">
                                <option value="" selected></option>
                                @foreach ($zonas as $zona)
                                    <option value="{{ $zona->id }}">{{ $zona->zona }}</option>
                                @endforeach

                            </select>

                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo">Tipo RD$</label>
                            <select class="form-control" name="tipo" id="tipo" wire:model.lazy="tipo">
                                <option value="" selected></option>
                                @foreach ($tipos_propiedades as $tipos_propiedad)
                                    <option value="{{ $tipos_propiedad->id }}">{{ $tipos_propiedad->tipo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estadopropiedad">Estado RD$</label>
                            <select class="form-control" name="estadopropiedad" id="estadopropiedad"
                                wire:model.lazy="estadopropiedad">
                                <option value="" selected></option>
                                @forelse ($estados_propiedad as $estado_propiedad)
                                    <option value="{{ $estado_propiedad->id }}">{{ $estado_propiedad->estado }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="precio_mini">Precio Min RD$</label>
                            <input type="text" class="form-control monto" id="precio_mini" name="precio_mini"
                                wire:model.lazy="precio_mini">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="precio_max">Precio Max RD$</label>
                            <input type="text" class="form-control monto" id="precio_max" name="precio_max"
                                wire:model.lazy="precio_max">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo_en_dolar">Tipo US$</label>
                            <select class="form-control" name="tipo_en_dolar" id="tipo_en_dolar"
                                wire:model.lazy="tipo_en_dolares">
                                <option value="" selected></option>
                                @foreach ($tipos_propiedades as $tipos_propiedad)
                                    <option value="{{ $tipos_propiedad->id }}">{{ $tipos_propiedad->tipo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estadopropiedad_en_dolar">Estado US$</label>
                            <select class="form-control" name="estadopropiedad_en_dolar"
                                id="estadopropiedad_en_dolar" wire:model.lazy="estadopropiedad_en_dolar">
                                <option value="" selected></option>
                                @forelse ($estados_propiedad as $estado_propiedad)
                                    <option value="{{ $estado_propiedad->id }}">{{ $estado_propiedad->estado }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="precio">Precio Min US$</label>
                            <input type="text" class="form-control monto" id="precio_mini_dolar"
                                name="precio_mini_dolar" wire:model.lazy="precio_mini_dolar">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="precio">Precio Max US$</label>
                            <input type="text" class="form-control monto" id="precio_max_dolar"
                                name="precio_max_dolar" wire:model.lazy="precio_max_dolar">
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
                            <select class="form-control" name="parqueos" id="parqueos" wire:model.lazy="parqueos">
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




                    @if ($Id > 0)
                        <div class="button-group mt-4">
                            <button class="btn btn-primary mb-2"
                                wire:click.prevent="updatePropuesta({{ $Id }})">Crear propuesta</button>
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

                {{-- <div class="modal-footer">
                    <form>            
                        <button type="button" class="btn btn-primary close-modal" @if ($grabar == 0) hidden @endif @if ($Id == 0) wire:click.prevent='store' @else wire:click.prevent='update({{$Id}})' @endif> @if ($Id == 0) Grabar @else Actualizar @endif </button>                                                
                        @if ($Id == 0)
                        <button type="button" class="btn btn-warning" wire:click='clear'>Cancelar</button>
                        @endif                                                
                        <button type="button" class="btn btn-info close-modal text-white" wire:click="limpiar_tarea()" wire:click='salir()' data-bs-dismiss="modal">Salir</button>
                        @if ($Id != 0)
                            <button type="button" class="btn btn-danger" wire:click="borrarConfirmacion({{$telefono}})">Borrar</button>
                        @endif
                    </form>
                </div>                  --}}

            </div>
        </div>



        @if ($Id != 0)

            <div class="row">

                <div class="card card-body shadow">


                    <div class="col-md-12">

                        <div class="col-md-12">
                            <div class="my-3">
                                <label for="" class="form-label">Notas @if ($id_nota != '')
                                        ID:{{ $id_nota }}
                                    @endif
                                </label>
                                <textarea class="form-control" name="nota" id="nota" rows="3" wire:model="nota"></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success btn-block m-1 p-1"
                                    @if ($id_nota == '') wire:click='agregarnota' @else wire:click='actualizarnota({{ $id_nota }})' @endif>
                                    @if ($id_nota == '')
                                        Grabar
                                    @else
                                        Actualizar
                                    @endif
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-block m-1 p-1"
                                    wire:click="limpiar_nota()">Cancelar
                                </button>
                            </div>
                        </div>

                        <div class="my-1">
                            @if (session('notaagregada'))
                                @if (session('notaagregada') != '')
                                    <div class="alert alert-success p-1">
                                        {{ session('notaagregada') }}
                                    </div>
                                @endif
                            @endif

                            @if (session('borrarnota'))
                                @if (session('borrarnota') != '')
                                    <div class="alert alert-danger p-1">
                                        {{ session('borrarnota') }}
                                    </div>
                                @endif
                            @endif

                            @if (session('editarnota'))
                                @if (session('editarnota') != '')
                                    <div class="alert alert-warning p-1">
                                        {{ session('editarnota') }}
                                    </div>
                                @endif
                            @endif

                            @if (session('actualizarnota'))
                                @if (session('actualizarnota') != '')
                                    <div class="alert alert-info p-1">
                                        {{ session('actualizarnota') }}
                                    </div>
                                @endif
                            @endif

                        </div>

                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4 class="text-dark mb-0">Notas</h4>
                                @error('nota')
                                    <span class="error text-danger p-2">{{ $message }} ....</span>
                                @enderror
                            </div>

                            @forelse ($notas as $nota)
                                <div class="card mb-1">
                                    <div class="card-body">


                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary fw-bold mb-0">
                                                    <span class="text-dark ms-2">
                                                        {{ $nota->nota }}
                                                    </span>
                                                </h6>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex flex-row">
                                                    <i class="fas"
                                                        style="color: #aaa;">{{ $nota->created_at }}</i>
                                                    <i class="far fa-star mx-2" style="color: #aaa;"></i>
                                                    <i class="far fa-check-circle text-primary"></i>
                                                </div>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success"
                                                        @click="$dispatch('actualizar-valor', 'true')"
                                                        wire:click="editarnota({{ $nota->id }})">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger"
                                                        wire:click="$emit('generarBorrarSweetAlert',{{ $nota->id }}, 'Borrar Nota ID ', 'borrarnota')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
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

            </div>
        @else
        @endif

        @if ($Id != 0)
            <div class="row card card-body shadow">
                <div class="row">
                    <div class="col-md-12 mb-3 table-responsive">

                        <div class="form-group">
                            <label for="nombre">Titulo de Tarea @if ($id_tarea != '')
                                    ID:{{ $id_tarea }}
                                @endif
                            </label>
                            <input type="text" class="form-control" wire:model.lazy="nombre_tarea"
                                placeholder="tarea" required>
                            @error('nombre_tarea')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" wire:model.lazy="descripcion_tarea" required rows="3"></textarea>
                            @error('descripcion_tarea')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Clientes">Tipo de Tarea</label>
                                    <select class="form-control" wire:model.lazy="tipo_tarea">
                                        <option selected>Tipo</option>
                                        @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->todo_tipo }}</option>
                                        @endforeach
                                    </select>
                                    @error('tipo_tarea')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha">Fecha*</label>
                                    <input type="datetime-local" class="form-control" placeholder="Fecha Limite"
                                        wire:model.lazy="fecha_tarea" required>
                                    @error('fecha_tarea')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Clientes">Estatus de la Tarea</label>
                                    <select class="form-control" wire:model.lazy="estatus_tarea">
                                        <option selected>Estatus</option>
                                        @foreach ($estatuses as $estatus)
                                            <option value="{{ $estatus->id }}">{{ $estatus->todo_estatus }}</option>
                                        @endforeach
                                    </select>
                                    @error('estatus_tarea')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div>
                                @if (session('agregartarea'))
                                    @if (session('agregartarea') != '')
                                        <div class="alert alert-success">
                                            {{ session('agregartarea') }}
                                        </div>
                                    @endif
                                @endif

                                @if (session('actualizartarea'))
                                    @if (session('actualizartarea') != '')
                                        <div class="alert alert-warning">
                                            {{ session('actualizartarea') }}
                                        </div>
                                    @endif
                                @endif

                                @if (session('editartarea'))
                                    @if (session('editartarea') != '')
                                        <div class="alert alert-info">
                                            {{ session('editartarea') }}
                                        </div>
                                    @endif
                                @endif

                                @if (session('borrartarea'))
                                    @if (session('borrartarea') != '')
                                        <div class="alert alert-danger">
                                            {{ session('borrartarea') }}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="row justify-content-end">
                                <div class="col-md-6">
                                    <a class="btn btn-success btn-block m-1 p-1"
                                        @if ($id_tarea == '') wire:click='agregartarea' @else wire:click='actualizartarea({{ $id_tarea }})' @endif
                                        role="button">
                                        @if ($id_tarea == '')
                                            Grabar
                                        @else
                                            Actualizar
                                        @endif
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-danger btn-block m-1 p-1" href="#"
                                        wire:click="limpiar_tarea()" role="button">Cancelar</a>
                                </div>
                            </div>
                        </div>


                        <div class="row my-1">

                            <div class="col-md-12">

                                <div class="card shadow col-md-12">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h4 class="text-dark mb-0">Tareas</h4>
                                        @error('nota')
                                            <span class="error text-danger p-2">{{ $message }} ....</span>
                                        @enderror
                                    </div>

                                    <table class="table table-striped m-1">
                                        <thead>
                                            <tr>
                                                <th class="d-none d-md-table-cell">#</th>
                                                <th class="">Fecha</th>
                                                <th class="">Titulo</th>
                                                <th class="d-none d-md-table-cell">Descripción</th>
                                                <th class="d-none d-md-table-cell">Tipo</th>
                                                <th class="">Estatus</th>
                                                <th class="text-center">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($tareas as $tarea)
                                                <tr>
                                                    <td class="d-none d-md-table-cell">{{ $tarea->id }}</td>
                                                    <td>{{ $tarea->fechaLimite }}</td>
                                                    <td>{{ $tarea->nombre }}</td>
                                                    <td class="d-none d-md-table-cell">{{ $tarea->descripcion }}</td>
                                                    <td class="d-none d-md-table-cell">{{ $tarea->todo_tipo }}</td>
                                                    <td>{{ $tarea->todo_estatus }}</td>


                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-success"
                                                                @click="$dispatch('actualizar-valor', 'true')"
                                                                wire:click="editartarea({{ $tarea->id }})">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger"
                                                                wire:click="$emit('generarBorrarSweetAlert',{{ $tarea->id }}, 'Borrar Tarea ID ', 'borrartarea')"
                                                                type="submit">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>

                                                </tr>


                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        @endif

        @include('components.modalfootercliente')


    </div>
