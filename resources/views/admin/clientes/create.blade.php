@extends('admin.layoutadmin')

@section('title', 'Nuevo contacto')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Contactos</a></li>
    <li class="breadcrumb-item active">Nuevo contacto</li>
@endsection

@section('page_title', 'Nuevo contacto')

@section('content')

    <div class="container-fluid px-3">
        <div class="card border-0 shadow-sm mb-3 overflow-hidden">
            <div class="card-body py-3" style="background: linear-gradient(120deg, #0f172a, #1e3a8a); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <h2 class="h4 mb-1 font-weight-bold">Registrar contacto</h2>
                        <p class="mb-0" style="opacity: .85;">Captura datos comerciales y preferencias para dar seguimiento
                            desde el CRM.</p>
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

        <form action="{{ route('clientes.store') }}" method="post" novalidate>
            @csrf

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="h5 mb-0">Datos del contacto</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" required class="form-control" id="nombre" name="nombre"
                                value="{{ old('nombre') }}" placeholder="Nombre completo">
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="titulo">Titulo</label>
                            <select class="form-control" name="titulo" id="titulo" required>
                                <option value="">Selecciona</option>
                                <option value="Señor" @selected(old('titulo') === 'Señor')>Señor</option>
                                <option value="Señora" @selected(old('titulo') === 'Señora')>Señora</option>
                                <option value="Señorita" @selected(old('titulo') === 'Señorita')>Señorita</option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="tipo_contacto">Tipo contacto</label>
                            <select class="form-control" name="tipo_contacto" id="tipo_contacto" required>
                                <option value="">Selecciona</option>
                                <option value="PersonaFisica" @selected(old('tipo_contacto') === 'PersonaFisica')>Persona fisica</option>
                                <option value="Empresa" @selected(old('tipo_contacto') === 'Empresa')>Empresa</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="telefono">Telefono</label>
                            <input type="number" required class="form-control" id="telefono" name="telefono"
                                value="{{ old('telefono') }}" placeholder="Numero principal">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="correo">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo"
                                value="{{ old('correo') }}" placeholder="correo@dominio.com">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="contact_at">Fecha de contacto</label>
                            <input type="date" class="form-control" required id="contact_at" name="contact_at"
                                value="{{ old('contact_at') }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="tipo_contacto2">Perfil</label>
                            <select class="form-control" name="tipo_contacto2" id="tipo_contacto2" required>
                                <option value="">Selecciona</option>
                                <option value="Vendedor" @selected(old('tipo_contacto2') === 'Vendedor')>Vendedor</option>
                                <option value="Comprador" @selected(old('tipo_contacto2') === 'Comprador')>Comprador</option>
                                <option value="Inquilino" @selected(old('tipo_contacto2') === 'Inquilino')>Inquilino</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="medio">Origen del contacto</label>
                            <select class="form-control" name="medio" id="medio" required>
                                <option value="">Selecciona</option>
                                <option value="Facebook" @selected(old('medio') === 'Facebook')>Facebook</option>
                                <option value="Instagram" @selected(old('medio') === 'Instagram')>Instagram</option>
                                <option value="Letrero" @selected(old('medio') === 'Letrero')>Letrero</option>
                                <option value="Radio" @selected(old('medio') === 'Radio')>Radio</option>
                                <option value="TV" @selected(old('medio') === 'TV')>TV</option>
                                <option value="Referido" @selected(old('medio') === 'Referido')>Referido</option>
                                <option value="PaginaWeb" @selected(old('medio') === 'PaginaWeb')>Pagina web</option>
                                <option value="Otro" @selected(old('medio') === 'Otro')>Otro</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group d-flex align-items-end">
                            <div class="custom-control custom-switch mb-2">
                                <input class="custom-control-input" type="checkbox" name="activo" id="activo"
                                    value="1" @checked(old('activo'))>
                                <label class="custom-control-label" for="activo">Marcar como activo</label>
                            </div>
                        </div>

                        <div class="col-12 form-group mb-0">
                            <label for="comentario">Comentario</label>
                            <textarea class="form-control" name="comentario" id="comentario" rows="3"
                                placeholder="Notas comerciales o necesidades del cliente">{{ old('comentario') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="h5 mb-0">Preferencias de negocio</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="zona_id">Zona</label>
                            <select class="form-control" name="zona_id" id="zona_id">
                                <option value="">Selecciona zona</option>
                                @foreach ($zonas as $zona)
                                    <option value="{{ $zona->id }}" @selected(old('zona_id') == $zona->id)>{{ $zona->zona }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="precio_mini">Precio minimo</label>
                            <input type="number" class="form-control" id="precio_mini" name="precio_mini"
                                value="{{ old('precio_mini') }}" placeholder="Ej. 50000">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="precio_max">Precio maximo</label>
                            <input type="number" class="form-control" id="precio_max" name="precio_max"
                                value="{{ old('precio_max') }}" placeholder="Ej. 120000">
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="habitaciones">Habitaciones</label>
                            <select class="form-control" name="habitaciones" id="habitaciones">
                                <option value="">Selecciona</option>
                                <option value="1" @selected(old('habitaciones') == '1')>1</option>
                                <option value="2" @selected(old('habitaciones') == '2')>2</option>
                                <option value="3" @selected(old('habitaciones') == '3')>3</option>
                                <option value="4" @selected(old('habitaciones') == '4')>4</option>
                                <option value="5" @selected(old('habitaciones') == '5')>5</option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="parqueos">Parqueos</label>
                            <select class="form-control" name="parqueos" id="parqueos">
                                <option value="">Selecciona</option>
                                <option value="1" @selected(old('parqueos') == '1')>1</option>
                                <option value="2" @selected(old('parqueos') == '2')>2</option>
                                <option value="3" @selected(old('parqueos') == '3')>3</option>
                                <option value="4" @selected(old('parqueos') == '4')>4</option>
                                <option value="5" @selected(old('parqueos') == '5')>5</option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="tipo">Tipo de propiedad</label>
                            <select class="form-control" name="tipo" id="tipo">
                                <option value="">Selecciona</option>
                                @foreach ($tipos_propiedades as $tipos_propiedad)
                                    <option value="{{ $tipos_propiedad->id }}" @selected(old('tipo') == $tipos_propiedad->id)>
                                        {{ $tipos_propiedad->tipo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="estadopropiedad">Estado de propiedad</label>
                            <select class="form-control" name="estadopropiedad" id="estadopropiedad">
                                <option value="">Selecciona</option>
                                @foreach ($estados_propiedad as $estado_propiedad)
                                    <option value="{{ $estado_propiedad->id }}" @selected(old('estadopropiedad') == $estado_propiedad->id)>
                                        {{ $estado_propiedad->estado }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="h5 mb-0">Testimonio</h3>
                </div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label for="testimonio">Detalle</label>
                        <textarea class="form-control" name="testimonio" id="testimonio" rows="3"
                            placeholder="Experiencia, observaciones o mensaje del cliente">{{ old('testimonio') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end pb-3">
                <button type="submit" class="btn btn-success px-4">
                    <i class="fas fa-save mr-1"></i> Guardar contacto
                </button>
            </div>
        </form>
    </div>

@endsection
