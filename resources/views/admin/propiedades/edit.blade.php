@extends('admin.layoutadmin')

@section('title', 'Editar Propiedad')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('propiedades.index') }}">Propiedades</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('page_title', 'Editar Propiedad')

@section('content')
    @php
        $isAdmin = auth()->check() && auth()->user()->hasAnyRole(['admin', 'superadmin']);
        $extraPhotos = ['foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8'];
        $amenities = [
            'lobby' => 'Lobby',
            'plantaelectrica' => 'Planta electrica',
            'camaravigilancia' => 'Camara de vigilancia',
            'escaleraemergencia' => 'Escalera de emergencia',
            'maderapreciosa' => 'Madera preciosa',
            'balcon' => 'Balcon',
            'walkincloset' => 'Walk in closet',
            'jacuzzi' => 'Jacuzzi',
            'areainfantil' => 'Area infantil',
            'banovisitas' => 'Bano de visitas',
            'cisterna' => 'Cisterna',
            'inversorareacomun' => 'Inversor area comun',
            'gascomun' => 'Gas comun',
            'gazebo' => 'Gazebo',
            'pozo' => 'Pozo',
            'piscina' => 'Piscina',
            'familyroom' => 'Family room',
            'cuartodeservicio' => 'Cuarto de servicio',
            'patio' => 'Patio',
            'portonelectrico' => 'Porton electrico',
            'seguridad24horas' => 'Seguridad 24 horas',
            'ascensor' => 'Ascensor',
            'parqueostechados' => 'Parqueos techados',
            'preinstalacionairetinacoinversor' => 'Pre-instalacion aire/tinaco/inversor',
            'terraza' => 'Terraza',
            'estudio' => 'Estudio',
            'gimnasio' => 'Gimnasio',
            'controldeacceso' => 'Control de acceso',
        ];

        $metaDescription = old('metadescription', $propiedad->metadescription ?: $propiedad->metadescripcion);
        $resolveImage = function ($value) {
            if (!$value) {
                return '';
            }

            if (\Illuminate\Support\Str::startsWith($value, ['http://', 'https://', '//', 'data:'])) {
                return $value;
            }

            if (\Illuminate\Support\Str::startsWith($value, ['/img/', '/assets/', 'img/', 'assets/'])) {
                return asset(ltrim($value, '/'));
            }

            return asset('assets/' . ltrim($value, '/'));
        };
    @endphp

    <div class="container-fluid modern-property-create py-4">
        <section class="create-hero mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h1 class="create-title mb-1">Editar Propiedad</h1>
                    <p class="create-subtitle mb-0">Actualiza la informacion comercial, SEO y multimedia usando el mismo
                        flujo visual de creacion.</p>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill">ID {{ $propiedad->id }}</span>
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill">{{ $propiedad->referencia }}</span>
                    @if ($isAdmin)
                        <a href="{{ route('asignar') }}" class="btn btn-outline-light">Asignar contacto</a>
                        <a href="{{ route('import.index') }}" class="btn btn-light text-dark border-0">Importar contactos</a>
                    @endif
                    <a href="{{ route('propiedades.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
                </div>
            </div>
        </section>

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm border-0" role="alert">
                <strong>Revisa los siguientes campos:</strong>
                <ul class="mb-0 mt-2 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('propiedades.update', $propiedad->id) }}" method="POST" enctype="multipart/form-data"
            novalidate>
            @csrf
            @method('put')
            <input type="hidden" name="id" value="{{ $propiedad->id }}">
            <input type="hidden" name="captada_por" value="{{ $propiedad->captada_por ?: auth()->id() }}">
            <input type="hidden" name="foto_vendedor" value="{{ $propiedad->foto_vendedor }}">
            <input type="hidden" name="metadescripcion" id="metadescripcion-sync" value="{{ $metaDescription }}">

            <div class="row g-4">
                <div class="col-xl-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h2 class="section-title">Informacion principal</h2>

                            <div class="form-group mb-3">
                                <label for="titulo" class="font-weight-bold">Titulo <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('titulo') is-invalid @enderror"
                                    id="titulo" name="titulo" value="{{ old('titulo', $propiedad->titulo) }}"
                                    placeholder="Ej: Apartamento familiar en Naco" required minlength="10" maxlength="60">
                                <small class="form-text text-muted">Entre 10 y 60 caracteres.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="descripcion_corta" class="font-weight-bold">Descripcion corta <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('descripcion_corta') is-invalid @enderror"
                                    id="descripcion_corta"
                                    value="{{ old('descripcion_corta', $propiedad->descripcion_corta) }}"
                                    name="descripcion_corta" placeholder="Resumen corto para listados y buscadores" required
                                    minlength="20" maxlength="160">
                                <small class="form-text text-muted">Entre 20 y 160 caracteres.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="descripcion" class="font-weight-bold">Descripcion completa <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                                    rows="10" placeholder="Describe distribucion, entorno, acabados y beneficios" required>{{ old('descripcion', $propiedad->descripcion) }}</textarea>
                            </div>

                            <div class="form-group mb-0">
                                <label for="direccion" class="font-weight-bold">Direccion</label>
                                <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" maxlength="200"
                                    rows="3" placeholder="Direccion referencial de la propiedad">{{ old('direccion', $propiedad->direccion) }}</textarea>
                                <small class="form-text text-muted">Maximo 200 caracteres.</small>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h2 class="section-title">Datos comerciales</h2>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="zona_id" class="font-weight-bold">Zona <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('zona_id') is-invalid @enderror" name="zona_id"
                                        id="zona_id" required>
                                        <option value="">Selecciona una zona</option>
                                        @foreach ($zonas as $zona)
                                            <option value="{{ $zona->id }}"
                                                {{ (string) old('zona_id', $propiedad->zona_id) === (string) $zona->id ? 'selected' : '' }}>
                                                {{ $zona->zona }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="provincia" class="font-weight-bold">Provincia <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('provincia') is-invalid @enderror" name="provincia"
                                        id="provincia" required>
                                        <option value="">Selecciona una provincia</option>
                                        @foreach ($provincias as $provincia)
                                            <option value="{{ $provincia->id }}"
                                                {{ (string) old('provincia', $propiedad->provincia) === (string) $provincia->id ? 'selected' : '' }}>
                                                {{ $provincia->provincia }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label for="tipomoneda" class="font-weight-bold">Moneda <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('tipomoneda') is-invalid @enderror"
                                        name="tipomoneda" id="tipomoneda" required>
                                        <option value="">Selecciona</option>
                                        <option value="RD$"
                                            {{ old('tipomoneda', $propiedad->Moneda) === 'RD$' ? 'selected' : '' }}>RD$
                                        </option>
                                        <option value="US$"
                                            {{ old('tipomoneda', $propiedad->Moneda) === 'US$' ? 'selected' : '' }}>US$
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-5 form-group">
                                    <label for="precio" class="font-weight-bold">Precio <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control monto @error('precio') is-invalid @enderror"
                                        id="precio" name="precio" required placeholder="Ej: 12,500,000"
                                        value="{{ old('precio', $propiedad->precio) }}">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="comision" class="font-weight-bold">Comision</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('comision') is-invalid @enderror" id="comision"
                                        name="comision" placeholder="Ej: 3.5"
                                        value="{{ old('comision', $propiedad->comision) }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="tipo" class="font-weight-bold">Tipo de propiedad <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('tipo') is-invalid @enderror" name="tipo"
                                        id="tipo" required>
                                        <option value="">Selecciona</option>
                                        @foreach ($tipos_propiedades as $tipos_propiedad)
                                            <option value="{{ $tipos_propiedad->id }}"
                                                {{ (string) old('tipo', $propiedad->tipo) === (string) $tipos_propiedad->id ? 'selected' : '' }}>
                                                {{ $tipos_propiedad->tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="disponible_para" class="font-weight-bold">Disponible para <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('disponible_para') is-invalid @enderror"
                                        name="disponible_para" id="disponible_para" required>
                                        <option value="">Selecciona</option>
                                        @foreach ($disponibles_para as $disponible_para)
                                            <option value="{{ $disponible_para->id }}"
                                                {{ (string) old('disponible_para', $propiedad->disponible_para) === (string) $disponible_para->id ? 'selected' : '' }}>
                                                {{ $disponible_para->disponible_para }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="estadopropiedad" class="font-weight-bold">Estado de propiedad <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('estadopropiedad') is-invalid @enderror"
                                        name="estadopropiedad" id="estadopropiedad" required>
                                        <option value="">Selecciona</option>
                                        @foreach ($estados_propiedad as $estado_propiedad)
                                            <option value="{{ $estado_propiedad->id }}"
                                                {{ (string) old('estadopropiedad', $propiedad->estado_id) === (string) $estado_propiedad->id ? 'selected' : '' }}>
                                                {{ $estado_propiedad->estado }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 form-group">
                                    <label for="habitaciones" class="font-weight-bold">Hab <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('habitaciones') is-invalid @enderror"
                                        name="habitaciones" id="habitaciones" required>
                                        <option value="">-</option>
                                        @for ($i = 0; $i <= 5; $i++)
                                            <option value="{{ $i }}"
                                                {{ (string) old('habitaciones', $propiedad->habitaciones) === (string) $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="banos" class="font-weight-bold">Banos <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('banos') is-invalid @enderror" name="banos"
                                        id="banos" required>
                                        <option value="">-</option>
                                        @foreach (['0', '1', '1.5', '2', '2.5', '3', '3.5', '4', '4.5', '5', '5.5'] as $banio)
                                            <option value="{{ $banio }}"
                                                {{ (string) old('banos', $propiedad->banos) === (string) $banio ? 'selected' : '' }}>
                                                {{ $banio }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="parqueos" class="font-weight-bold">Parqueos <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('parqueos') is-invalid @enderror" name="parqueos"
                                        id="parqueos" required>
                                        <option value="">-</option>
                                        @for ($i = 0; $i <= 5; $i++)
                                            <option value="{{ $i }}"
                                                {{ (string) old('parqueos', $propiedad->parqueos) === (string) $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label for="metraje" class="font-weight-bold">Metraje <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('metraje') is-invalid @enderror"
                                        id="metraje" name="metraje" placeholder="Ej: 185"
                                        value="{{ old('metraje', $propiedad->metraje) }}" required>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label for="metraje_construccion" class="font-weight-bold">Metraje
                                        construccion</label>
                                    <input type="text"
                                        class="form-control @error('metraje_construccion') is-invalid @enderror"
                                        id="metraje_construccion" name="metraje_construccion" placeholder="Ej: 160"
                                        value="{{ old('metraje_construccion', $propiedad->metraje_construccion) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                                <h2 class="section-title mb-0">Amenidades y estado</h2>
                                <small class="text-muted">Selecciona solo las que apliquen</small>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <label class="toggle-chip">
                                    <input type="checkbox" name="destacada" id="destacada"
                                        {{ old('destacada', $propiedad->destacada) ? 'checked' : '' }}>
                                    <span>Destacada</span>
                                </label>
                                <label class="toggle-chip">
                                    <input type="checkbox" name="vendida" id="vendida"
                                        {{ old('vendida', $propiedad->vendida) ? 'checked' : '' }}>
                                    <span>Vendida</span>
                                </label>
                                <label class="toggle-chip">
                                    <input type="checkbox" name="activa" id="activa"
                                        {{ old('activa', $propiedad->activa) ? 'checked' : '' }}>
                                    <span>Activa</span>
                                </label>
                                @if (optional($inmobiliaria)->aprobacion == 'on' && Auth::user()->rol == 0)
                                    <label class="toggle-chip">
                                        <input type="checkbox" name="aprobada" id="aprobada"
                                            {{ old('aprobada', $propiedad->aprobada) ? 'checked' : '' }}>
                                        <span>Aprobada</span>
                                    </label>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 form-group mb-0">
                                    <label for="fechacierre" class="font-weight-bold">Fecha de cierre</label>
                                    <input type="date" class="form-control" id="fechacierre" name="fechacierre"
                                        value="{{ old('fechacierre', $propiedad->fechacierre) }}">
                                </div>
                            </div>

                            <div class="row">
                                @foreach ($amenities as $key => $label)
                                    <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                                        <label class="toggle-chip w-100 mb-0">
                                            <input type="checkbox" name="{{ $key }}" id="{{ $key }}"
                                                {{ old($key, data_get($propiedad, $key)) ? 'checked' : '' }}>
                                            <span>{{ $label }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow-sm border-0 mb-4 sticky-media-card">
                        <div class="card-body p-4">
                            <h2 class="section-title">Portada y galeria</h2>

                            <div class="form-group mb-4">
                                <label class="font-weight-bold d-block mb-2">Foto principal</label>
                                <div class="edit-dropzone edit-dropzone-cover" id="cover-dropzone" tabindex="0"
                                    role="button">
                                    <img src="{{ $resolveImage($propiedad->foto_portada) }}" alt="Portada actual"
                                        id="cover-preview"
                                        class="dropzone-cover-preview {{ $propiedad->foto_portada ? '' : 'd-none' }}">
                                    <div id="cover-empty"
                                        class="dropzone-empty-state {{ $propiedad->foto_portada ? 'd-none' : '' }}">
                                        <strong>{{ $propiedad->foto_portada ? 'Reemplazar portada' : 'Selecciona una portada' }}</strong>
                                        <span>JPG, PNG o WebP horizontal.</span>
                                    </div>
                                </div>
                                <input type="file" class="d-none" id="foto_portada" name="foto_portada"
                                    accept="image/*">
                                <small class="form-text text-muted d-block mt-2">Haz clic o arrastra una imagen para
                                    reemplazar la portada actual.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold d-block mb-2">Galeria (opcionales)</label>
                                <div class="gallery-slot-grid">
                                    @foreach ($extraPhotos as $index => $photoField)
                                        @php
                                            $photoValue = data_get($propiedad, $photoField);
                                            $removeField = 'ckfoto' . ($index + 1);
                                            $slotId = 'slot-' . ($index + 1);
                                            $previewId = 'preview-' . ($index + 1);
                                            $emptyId = 'empty-' . ($index + 1);
                                        @endphp
                                        <div class="gallery-slot-card">
                                            <div class="small font-weight-bold text-muted mb-2">
                                                {{ strtoupper($photoField) }}</div>
                                            <div class="edit-dropzone gallery-dropzone" id="{{ $slotId }}"
                                                tabindex="0" role="button">
                                                <img src="{{ $resolveImage($photoValue) }}" alt="{{ $photoField }}"
                                                    id="{{ $previewId }}"
                                                    class="gallery-preview-image {{ $photoValue ? '' : 'd-none' }}">
                                                <div id="{{ $emptyId }}"
                                                    class="dropzone-empty-state {{ $photoValue ? 'd-none' : '' }}">
                                                    <strong>{{ $photoValue ? 'Reemplazar foto' : 'Agregar foto' }}</strong>
                                                    <span>{{ $photoValue ? 'Puedes soltar una nueva imagen aqui.' : 'Slot disponible' }}</span>
                                                </div>
                                            </div>
                                            <input type="file" class="d-none" id="{{ $photoField }}"
                                                name="{{ $photoField }}" accept="image/*">
                                            @if ($photoValue)
                                                <label
                                                    class="toggle-chip w-100 justify-content-center mt-2 mb-0 remove-chip">
                                                    <input type="checkbox" name="{{ $removeField }}"
                                                        id="{{ $removeField }}">
                                                    <span>Eliminar actual</span>
                                                </label>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr class="my-3">

                            <div class="form-group mb-0">
                                <label for="video1" class="font-weight-bold">Video de YouTube</label>
                                <input class="form-control" type="text" id="video1" name="video1"
                                    value="{{ old('video1', $propiedad->video1) }}"
                                    placeholder="https://www.youtube.com/watch?v=...">
                                <small class="form-text text-muted">Opcional: enlace completo del video</small>
                                <div id="video1-preview-wrapper" class="mt-3 d-none" aria-live="polite">
                                    <div class="rounded overflow-hidden border"
                                        style="position:relative; padding-top:56.25%; background:#f6f8fb;">
                                        <iframe id="video1-preview-frame" src=""
                                            title="Vista previa del video de YouTube" loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen referrerpolicy="strict-origin-when-cross-origin"
                                            style="position:absolute; inset:0; width:100%; height:100%; border:0;"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h2 class="section-title">SEO de la propiedad</h2>
                            <div class="form-group mb-0">
                                <label for="metadescription" class="font-weight-bold">Meta description <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('metadescription') is-invalid @enderror" id="metadescription"
                                    name="metadescription" minlength="20" maxlength="160" rows="4" required
                                    placeholder="Descripcion para buscadores (20-160 caracteres)">{{ $metaDescription }}</textarea>
                                <small class="form-text text-muted d-block mt-2">Entre 20 y 160 caracteres para
                                    buscadores.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="d-grid gap-2 gap-sm-3" style="grid-auto-flow: column; grid-auto-columns: 1fr;">
                        <button type="submit" class="btn btn-primary btn-lg">Guardar cambios</button>
                        <a href="{{ route('propiedades.index') }}" class="btn btn-light border">Cancelar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        .modern-property-create {
            --brand-900: #12343b;
            --brand-700: #1c4f59;
            --brand-100: #eaf3f5;
            --accent-600: #b66a20;
            --neutral-200: #e5e7eb;
        }

        .create-hero {
            background: linear-gradient(130deg, var(--brand-900), var(--brand-700));
            color: #fff;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 10px 20px rgba(18, 52, 59, 0.2);
        }

        .create-title {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 0.01em;
        }

        .create-subtitle {
            opacity: 0.9;
            max-width: 760px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--brand-900);
            margin-bottom: 1rem;
        }

        .sticky-media-card {
            position: sticky;
            top: 1rem;
        }

        .toggle-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            border: 1px solid var(--neutral-200);
            border-radius: 999px;
            padding: 0.4rem 0.75rem;
            cursor: pointer;
            background: #fff;
            transition: all 0.2s ease;
        }

        .toggle-chip:hover {
            border-color: #c3ccd6;
            transform: translateY(-1px);
        }

        .toggle-chip input {
            width: 1rem;
            height: 1rem;
        }

        .toggle-chip input:checked+span {
            font-weight: 600;
            color: var(--accent-600);
        }

        .edit-dropzone {
            border: 2px dashed #d4d9e0;
            border-radius: 0.75rem;
            padding: 1rem;
            background: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .edit-dropzone:hover,
        .edit-dropzone:focus,
        .edit-dropzone.is-dragover {
            background: #f5f7fa;
            border-color: #b66a20;
            outline: none;
        }

        .edit-dropzone-cover {
            min-height: 240px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropzone-cover-preview,
        .gallery-preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0.6rem;
        }

        .dropzone-empty-state {
            min-height: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #6c757d;
            gap: 0.25rem;
            font-size: 0.9rem;
        }

        .dropzone-empty-state strong {
            color: #1c4f59;
        }

        .gallery-slot-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.85rem;
        }

        .gallery-slot-card {
            border: 1px solid #e5e7eb;
            border-radius: 0.85rem;
            padding: 0.75rem;
            background: #fbfcfd;
        }

        .gallery-dropzone {
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-chip {
            font-size: 0.85rem;
        }

        .ck-editor__editable_inline {
            min-height: 320px;
        }

        @media (max-width: 1199.98px) {
            .sticky-media-card {
                position: static;
            }
        }

        @media (max-width: 767.98px) {
            .gallery-slot-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 575.98px) {
            .create-title {
                font-size: 1.45rem;
            }

            .d-grid[style*='grid-auto-flow: column'] {
                grid-auto-flow: row !important;
                grid-auto-columns: unset !important;
            }
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const metaVisible = document.getElementById('metadescription');
            const metaHidden = document.getElementById('metadescripcion-sync');

            const extractYouTubeId = (value) => {
                const rawValue = (value || '').trim();
                if (!rawValue) {
                    return '';
                }

                const idPattern = /^[a-zA-Z0-9_-]{11}$/;
                if (idPattern.test(rawValue)) {
                    return rawValue;
                }

                try {
                    const parsedUrl = new URL(rawValue);
                    const hostname = parsedUrl.hostname.replace('www.', '');

                    if (hostname === 'youtu.be') {
                        return parsedUrl.pathname.split('/').filter(Boolean)[0] || '';
                    }

                    if (hostname === 'youtube.com' || hostname === 'm.youtube.com' || hostname === 'youtube-nocookie.com') {
                        if (parsedUrl.pathname === '/watch') {
                            return parsedUrl.searchParams.get('v') || '';
                        }

                        const pathParts = parsedUrl.pathname.split('/').filter(Boolean);
                        if (pathParts[0] === 'embed' || pathParts[0] === 'shorts') {
                            return pathParts[1] || '';
                        }
                    }
                } catch (error) {
                    // Si no es URL valida, intentamos extraer un ID suelto.
                }

                const fallbackMatch = rawValue.match(
                    /(?:v=|\/embed\/|youtu\.be\/|\/shorts\/)([a-zA-Z0-9_-]{11})/
                );
                return fallbackMatch ? fallbackMatch[1] : '';
            };

            const refreshVideoPreview = () => {
                const videoInput = document.getElementById('video1');
                const previewWrapper = document.getElementById('video1-preview-wrapper');
                const previewFrame = document.getElementById('video1-preview-frame');

                if (!videoInput || !previewWrapper || !previewFrame) {
                    return;
                }

                const videoId = extractYouTubeId(videoInput.value);
                if (!videoId) {
                    previewFrame.src = '';
                    previewWrapper.classList.add('d-none');
                    return;
                }

                previewFrame.src = `https://www.youtube.com/embed/${videoId}`;
                previewWrapper.classList.remove('d-none');
            };

            const videoInput = document.getElementById('video1');
            if (videoInput) {
                videoInput.addEventListener('input', refreshVideoPreview);
                videoInput.addEventListener('blur', refreshVideoPreview);
                refreshVideoPreview();
            }

            if (metaVisible && metaHidden) {
                const syncMeta = () => {
                    metaHidden.value = metaVisible.value;
                };

                metaVisible.addEventListener('input', syncMeta);
                syncMeta();
            }

            const bindDropzone = ({
                zoneId,
                inputId,
                previewId,
                emptyId,
                removeId
            }) => {
                const zone = document.getElementById(zoneId);
                const input = document.getElementById(inputId);
                const preview = previewId ? document.getElementById(previewId) : null;
                const empty = emptyId ? document.getElementById(emptyId) : null;
                const removeCheckbox = removeId ? document.getElementById(removeId) : null;

                if (!zone || !input) {
                    return;
                }

                const openPicker = () => input.click();

                zone.addEventListener('click', (event) => {
                    if (event.target.closest('label') || event.target.closest(
                        'input[type="checkbox"]')) {
                        return;
                    }
                    openPicker();
                });

                zone.addEventListener('keydown', (event) => {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        openPicker();
                    }
                });

                ['dragenter', 'dragover'].forEach((eventName) => {
                    zone.addEventListener(eventName, (event) => {
                        event.preventDefault();
                        zone.classList.add('is-dragover');
                    });
                });

                ['dragleave', 'dragend', 'drop'].forEach((eventName) => {
                    zone.addEventListener(eventName, (event) => {
                        event.preventDefault();
                        zone.classList.remove('is-dragover');
                    });
                });

                zone.addEventListener('drop', (event) => {
                    const file = event.dataTransfer?.files?.[0];
                    if (!file) {
                        return;
                    }

                    const transfer = new DataTransfer();
                    transfer.items.add(file);
                    input.files = transfer.files;
                    input.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                });

                input.addEventListener('change', () => {
                    const file = input.files?.[0];
                    if (!file || !preview) {
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (loadEvent) => {
                        preview.src = loadEvent.target.result;
                        preview.classList.remove('d-none');
                        if (empty) {
                            empty.classList.add('d-none');
                        }
                        if (removeCheckbox) {
                            removeCheckbox.checked = false;
                        }
                    };
                    reader.readAsDataURL(file);
                });
            };

            bindDropzone({
                zoneId: 'cover-dropzone',
                inputId: 'foto_portada',
                previewId: 'cover-preview',
                emptyId: 'cover-empty',
            });

            [1, 2, 3, 4, 5, 6, 7, 8].forEach((index) => {
                bindDropzone({
                    zoneId: `slot-${index}`,
                    inputId: `foto${index}`,
                    previewId: `preview-${index}`,
                    emptyId: `empty-${index}`,
                    removeId: `ckfoto${index}`,
                });
            });

            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.descripcion) {
                return;
            }

            if (typeof ClassicEditor !== 'undefined') {
                ClassicEditor
                    .create(document.querySelector('#descripcion'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                            'blockQuote'
                        ],
                        heading: {
                            options: [{
                                    model: 'paragraph',
                                    title: 'Parrafo',
                                    class: 'ck-heading_paragraph'
                                },
                                {
                                    model: 'heading1',
                                    view: 'h1',
                                    title: 'Encabezado 1',
                                    class: 'ck-heading_heading1'
                                },
                                {
                                    model: 'heading2',
                                    view: 'h2',
                                    title: 'Encabezado 2',
                                    class: 'ck-heading_heading2'
                                }
                            ]
                        }
                    })
                    .then((editor) => {
                        editor.editing.view.change((writer) => {
                            writer.setStyle('min-height', '320px', editor.editing.view.document
                            .getRoot());
                        });
                    })
                    .catch((error) => {
                        console.error('CKEditor 5 error:', error);
                    });
            }
        });
    </script>
@endpush
