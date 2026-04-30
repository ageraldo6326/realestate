@extends('admin.layoutadmin')

@section('title', 'Editar contacto')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Contactos</a></li>
    <li class="breadcrumb-item active">Editar contacto</li>
@endsection

@section('page_title', 'Editar contacto')

@section('content')

    <div class="container-fluid px-3">
        <div class="card border-0 shadow-sm mb-3 overflow-hidden">
            <div class="card-body py-3" style="background: linear-gradient(120deg, #0f172a, #1e3a8a); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <h2 class="h4 mb-1 font-weight-bold">Editar contacto</h2>
                        <p class="mb-0" style="opacity: .85;">ID #{{ $cliente->id }} &mdash; {{ $cliente->nombre }}</p>
                    </div>
                    <a href="{{ route('clientes.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Volver al listado
                    </a>
                </div>
            </div>
        </div>

        @if (session('existe'))
            <div class="alert alert-warning border-0 shadow-sm">{{ session('existe') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm">
                <div class="font-weight-bold mb-1">No se pudo guardar el contacto:</div>
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('clientes.update', $cliente->id) }}" method="post" novalidate>
            @method('PUT')
            @csrf

            {{-- Datos del contacto --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="h5 mb-0">Datos del contacto</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" required class="form-control" id="nombre" name="nombre"
                                value="{{ old('nombre', $cliente->nombre) }}" placeholder="Nombre completo">
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="titulo">Titulo</label>
                            <select class="form-control" name="titulo" id="titulo">
                                <option value="">Selecciona</option>
                                <option value="Señor" @if(old('titulo', $cliente->titulo) === 'Señor') selected @endif>Señor</option>
                                <option value="Señora" @if(old('titulo', $cliente->titulo) === 'Señora') selected @endif>Señora</option>
                                <option value="Señorita" @if(old('titulo', $cliente->titulo) === 'Señorita') selected @endif>Señorita</option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="tipo_contacto">Tipo contacto</label>
                            <select class="form-control" name="tipo_contacto" id="tipo_contacto">
                                <option value="">Selecciona</option>
                                <option value="PersonaFisica" @if(old('tipo_contacto', $cliente->tipo_contacto) === 'PersonaFisica') selected @endif>Persona fisica</option>
                                <option value="Empresa" @if(old('tipo_contacto', $cliente->tipo_contacto) === 'Empresa') selected @endif>Empresa</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="telefono">Telefono</label>
                            <input type="number" class="form-control" id="telefono" name="telefono_display"
                                value="{{ $cliente->telefono }}" placeholder="Numero principal" disabled>
                            <input type="hidden" name="telefono" value="{{ $cliente->telefono }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="email">Correo</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $cliente->email) }}" placeholder="correo@dominio.com">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="contact_at">Fecha de contacto</label>
                            <input type="date" class="form-control" required id="contact_at" name="contact_at"
                                value="{{ old('contact_at', substr($cliente->contact_at, 0, 10)) }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="tipo_contacto2">Perfil</label>
                            <select class="form-control" name="tipo_contacto2" id="tipo_contacto2">
                                <option value="">Selecciona</option>
                                <option value="Vendedor" @if(old('tipo_contacto2', $cliente->tipo_contacto2) === 'Vendedor') selected @endif>Vendedor</option>
                                <option value="Comprador" @if(old('tipo_contacto2', $cliente->tipo_contacto2) === 'Comprador') selected @endif>Comprador</option>
                                <option value="Inquilino" @if(old('tipo_contacto2', $cliente->tipo_contacto2) === 'Inquilino') selected @endif>Inquilino</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="medio">Origen del contacto</label>
                            <select class="form-control" name="medio" id="medio">
                                <option value="">Selecciona</option>
                                <option value="Facebook" @if(old('medio', $cliente->medio) === 'Facebook') selected @endif>Facebook</option>
                                <option value="Instagram" @if(old('medio', $cliente->medio) === 'Instagram') selected @endif>Instagram</option>
                                <option value="Letrero" @if(old('medio', $cliente->medio) === 'Letrero') selected @endif>Letrero</option>
                                <option value="Radio" @if(old('medio', $cliente->medio) === 'Radio') selected @endif>Radio</option>
                                <option value="TV" @if(old('medio', $cliente->medio) === 'TV') selected @endif>TV</option>
                                <option value="Referido" @if(old('medio', $cliente->medio) === 'Referido') selected @endif>Referido</option>
                                <option value="PaginaWeb" @if(old('medio', $cliente->medio) === 'PaginaWeb') selected @endif>Pagina web</option>
                                <option value="Otro" @if(old('medio', $cliente->medio) === 'Otro') selected @endif>Otro</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group d-flex align-items-end">
                            <div class="custom-control custom-switch mb-2">
                                <input class="custom-control-input" type="checkbox" name="activo" id="activo"
                                    value="1" @if(old('activo', $cliente->activo)) checked @endif>
                                <label class="custom-control-label" for="activo">Marcar como activo</label>
                            </div>
                        </div>

                        <div class="col-12 form-group mb-0">
                            <label for="comentario">Comentario</label>
                            <textarea class="form-control" name="comentario" id="comentario" rows="3"
                                placeholder="Notas comerciales o necesidades del cliente">{{ old('comentario', $cliente->comentario) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Estatus CRM --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="h5 mb-0">Estatus CRM</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="estatus">Estatus</label>
                            <select class="form-control" name="estatus" id="estatus">
                                <option value="">Selecciona</option>
                                <option value="NUEVO" @if(old('estatus', $cliente->estatus) === 'NUEVO') selected @endif>Nuevo</option>
                                <option value="CONTACTADO" @if(old('estatus', $cliente->estatus) === 'CONTACTADO') selected @endif>Contactado</option>
                                <option value="ACTIVO" @if(old('estatus', $cliente->estatus) === 'ACTIVO') selected @endif>Activo</option>
                                <option value="FUTURO" @if(old('estatus', $cliente->estatus) === 'FUTURO') selected @endif>Futuro</option>
                                <option value="CIERRE" @if(old('estatus', $cliente->estatus) === 'CIERRE') selected @endif>Cierre</option>
                                <option value="DESCARTADO" @if(old('estatus', $cliente->estatus) === 'DESCARTADO') selected @endif>Descartado</option>
                                <option value="NOESCLIENTE" @if(old('estatus', $cliente->estatus) === 'NOESCLIENTE') selected @endif>No es cliente potencial</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="probabilidades">Probabilidades</label>
                            <select class="form-control" name="probabilidades" id="probabilidades">
                                <option value="">Selecciona</option>
                                <option value="BAJAS" @if(old('probabilidades', $cliente->probabilidades) === 'BAJAS') selected @endif>Bajas</option>
                                <option value="MEDIAS" @if(old('probabilidades', $cliente->probabilidades) === 'MEDIAS') selected @endif>Medias</option>
                                <option value="ALTAS" @if(old('probabilidades', $cliente->probabilidades) === 'ALTAS') selected @endif>Altas</option>
                                <option value="DESCONOCIDA" @if(old('probabilidades', $cliente->probabilidades) === 'DESCONOCIDA') selected @endif>Desconocida</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="captadas_por">Buscar propiedades</label>
                            <select class="form-control" name="captadas_por" id="captadas_por">
                                <option value="">Todas</option>
                                <option value="mi" @if(old('captadas_por', $cliente->captadas_por) === 'mi') selected @endif>Solo mis propiedades</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preferencias de negocio (RD$) --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="h5 mb-0">Preferencias de negocio <span class="text-muted small">(RD$)</span></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="zona_id">Zona</label>
                            <select class="form-control" name="zona_id" id="zona_id">
                                <option value="">Selecciona zona</option>
                                @foreach ($zonas as $zona)
                                    <option value="{{ $zona->id }}" @if(old('zona_id', $cliente->zona_id) == $zona->id) selected @endif>{{ $zona->zona }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="precio_mini">Precio minimo</label>
                            <input type="number" class="form-control" id="precio_mini" name="precio_mini"
                                value="{{ old('precio_mini', $cliente->precio_mini) }}" placeholder="Ej. 50000">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="precio_max">Precio maximo</label>
                            <input type="number" class="form-control" id="precio_max" name="precio_max"
                                value="{{ old('precio_max', $cliente->precio_max) }}" placeholder="Ej. 120000">
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="habitaciones">Habitaciones</label>
                            <select class="form-control" name="habitaciones" id="habitaciones">
                                <option value="">Selecciona</option>
                                @foreach ([1, 2, 3, 4, 5] as $num)
                                    <option value="{{ $num }}" @if(old('habitaciones', $cliente->habitaciones) == $num) selected @endif>{{ $num }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="parqueos">Parqueos</label>
                            <select class="form-control" name="parqueos" id="parqueos">
                                <option value="">Selecciona</option>
                                @foreach ([1, 2, 3, 4, 5] as $num)
                                    <option value="{{ $num }}" @if(old('parqueos', $cliente->parqueos) == $num) selected @endif>{{ $num }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="tipo">Tipo de propiedad</label>
                            <select class="form-control" name="tipo" id="tipo">
                                <option value="">Selecciona</option>
                                @foreach ($tipos_propiedades as $tipos_propiedad)
                                    <option value="{{ $tipos_propiedad->id }}" @if(old('tipo', $cliente->tipo) == $tipos_propiedad->id) selected @endif>{{ $tipos_propiedad->tipo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="estadopropiedad">Estado de propiedad</label>
                            <select class="form-control" name="estadopropiedad" id="estadopropiedad">
                                <option value="">Selecciona</option>
                                @foreach ($estados_propiedad as $estado_propiedad)
                                    <option value="{{ $estado_propiedad->id }}" @if(old('estadopropiedad', $cliente->estado) == $estado_propiedad->id) selected @endif>{{ $estado_propiedad->estado }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mt-1">
                            <a href="{{ route('veropciones', $cliente->id) }}" target="_blank"
                                class="btn btn-outline-info btn-sm">
                                <i class="fas fa-search mr-1"></i> Ver opciones en RD$
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preferencias de negocio (US$) --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="h5 mb-0">Preferencias de negocio <span class="text-muted small">(US$)</span></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="precio_mini_dolar">Precio minimo (US$)</label>
                            <input type="number" class="form-control" id="precio_mini_dolar" name="precio_mini_dolar"
                                value="{{ old('precio_mini_dolar', $cliente->precio_mini_dolar) }}" placeholder="Ej. 50000">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="precio_max_dolar">Precio maximo (US$)</label>
                            <input type="number" class="form-control" id="precio_max_dolar" name="precio_max_dolar"
                                value="{{ old('precio_max_dolar', $cliente->precio_max_dolar) }}" placeholder="Ej. 120000">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="estadopropiedad_en_dolar">Estado de propiedad (US$)</label>
                            <select class="form-control" name="estadopropiedad_en_dolar" id="estadopropiedad_en_dolar">
                                <option value="">Selecciona</option>
                                @foreach ($estados_propiedad as $estado_propiedad)
                                    <option value="{{ $estado_propiedad->id }}" @if(old('estadopropiedad_en_dolar', $cliente->estado_en_dolares) == $estado_propiedad->id) selected @endif>{{ $estado_propiedad->estado }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="tipo_en_dolares">Tipo de propiedad (US$)</label>
                            <select class="form-control" name="tipo_en_dolares" id="tipo_en_dolares">
                                <option value="">Selecciona</option>
                                @foreach ($tipos_propiedades as $tipos_propiedad)
                                    <option value="{{ $tipos_propiedad->id }}" @if(old('tipo_en_dolares', $cliente->tipo_en_dolares) == $tipos_propiedad->id) selected @endif>{{ $tipos_propiedad->tipo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mt-1">
                            <a href="{{ route('veropcionesendolares', $cliente->id) }}" target="_blank"
                                class="btn btn-outline-success btn-sm">
                                <i class="fas fa-search mr-1"></i> Ver opciones en US$
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Testimonio --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="h5 mb-0">Testimonio</h3>
                </div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label for="testimonio">Detalle</label>
                        <textarea class="form-control" name="testimonio" id="testimonio" rows="3"
                            placeholder="Experiencia, observaciones o mensaje del cliente">{{ old('testimonio', $cliente->testimonio) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between pb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary px-4">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-success px-4">
                    <i class="fas fa-save mr-1"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>

@endsection