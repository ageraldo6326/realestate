@extends('admin.layoutadmin')

@section('content')
    @php
        $isAdmin =
            auth()->check() &&
            auth()
                ->user()
                ->hasAnyRole(['admin', 'superadmin']);
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
    @endphp

    <div class="container-fluid modern-property-create py-4">
        <section class="create-hero mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h1 class="create-title mb-1">Crear Propiedad</h1>
                    <p class="create-subtitle mb-0">Completa la informacion comercial, SEO y multimedia para publicar un
                        inmueble con calidad.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @if ($isAdmin)
                        <a href="{{ route('asignar') }}" class="btn btn-outline-light">
                            Asignar contacto
                        </a>
                        <a href="{{ route('import.index') }}" class="btn btn-light text-dark border-0">
                            Importar contactos
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <div id="property-form-errors" class="alert alert-danger shadow-sm border-0 {{ $errors->any() ? '' : 'd-none' }}"
            role="alert">
            <strong>Revisa los siguientes campos:</strong>
            <ul id="property-form-errors-list" class="mb-0 mt-2 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        <form action="{{ route('propiedades.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="row g-4">
                <div class="col-xl-8 property-form-sections">
                    <div class="card shadow-sm border-0 mb-4 property-section-main">
                        <div class="card-body p-4">
                            <h2 class="section-title">Informacion principal</h2>

                            <div class="form-group mb-2">
                                <label for="ia_instrucciones_propiedad" class="font-weight-bold">Instrucciones para IA
                                    (opcional)</label>
                                <input type="text" class="form-control" id="ia_instrucciones_propiedad" maxlength="220"
                                    placeholder="Ej: tono premium para inversionistas, enfocar rentabilidad y ubicacion">
                                <small class="form-text text-muted">Despues de completar caracteristicas, la IA puede
                                    generar titulo, descripcion y meta description.</small>
                            </div>

                            <div class="form-group mb-4">
                                <button type="button" class="btn btn-outline-primary" id="btn-generar-ia-propiedad">
                                    <span id="ia-propiedad-spinner" class="spinner-border spinner-border-sm mr-1 d-none"
                                        role="status" aria-hidden="true"></span>
                                    <span id="ia-propiedad-label">Generar textos con IA</span>
                                </button>
                            </div>

                            <div class="form-group mb-3">
                                <label for="titulo" class="font-weight-bold">Titulo <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('titulo') is-invalid @enderror"
                                    id="titulo" name="titulo" value="{{ old('titulo') }}"
                                    placeholder="Ej: Apartamento familiar en Naco" required minlength="10" maxlength="60">
                                <small class="form-text text-muted">Entre 10 y 60 caracteres.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="descripcion_corta" class="font-weight-bold">Descripcion corta <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('descripcion_corta') is-invalid @enderror"
                                    id="descripcion_corta" value="{{ old('descripcion_corta') }}" name="descripcion_corta"
                                    placeholder="Resumen corto para listados y buscadores" required minlength="20"
                                    maxlength="160">
                                <small class="form-text text-muted">Entre 20 y 160 caracteres.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="descripcion" class="font-weight-bold">Descripcion completa <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                                    rows="10" placeholder="Describe distribucion, entorno, acabados y beneficios" required>{{ old('descripcion') }}</textarea>
                            </div>

                            <div class="form-group mb-0">
                                <label for="direccion" class="font-weight-bold">Direccion</label>
                                <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" maxlength="200"
                                    rows="3" placeholder="Direccion referencial de la propiedad">{{ old('direccion') }}</textarea>
                                <small class="form-text text-muted">Maximo 200 caracteres.</small>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4 property-section-commercial">
                        <div class="card-body p-4">
                            <h2 class="section-title">Datos comerciales</h2>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="provincia" class="font-weight-bold">Provincia <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('provincia') is-invalid @enderror" name="provincia"
                                        id="provincia" required>
                                        <option value="">Selecciona una provincia</option>
                                        @foreach ($provincias as $provincia)
                                            <option value="{{ $provincia->id }}"
                                                {{ old('provincia') == $provincia->id ? 'selected' : '' }}>
                                                {{ $provincia->provincia }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="sector_id" class="font-weight-bold">Sector <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('sector_id') is-invalid @enderror" name="sector_id"
                                        id="sector_id" required>
                                        <option value="">Selecciona un sector</option>
                                        @foreach ($sectores as $sector)
                                            <option value="{{ $sector->id }}"
                                                data-provincia="{{ $sector->provincia_id }}"
                                                {{ old('sector_id') == $sector->id ? 'selected' : '' }}>
                                                {{ $sector->sector }}</option>
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
                                        <option value="RD$" {{ old('tipomoneda', 'RD$') === 'RD$' ? 'selected' : '' }}>
                                            RD$</option>
                                        <option value="US$" {{ old('tipomoneda') === 'US$' ? 'selected' : '' }}>US$
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-5 form-group">
                                    <label for="precio" class="font-weight-bold">Precio <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control monto @error('precio') is-invalid @enderror"
                                        id="precio" name="precio" required placeholder="Ej: 12,500,000"
                                        value="{{ old('precio') }}">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="comision" class="font-weight-bold">Comision</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('comision') is-invalid @enderror" id="comision"
                                        name="comision" placeholder="Ej: 3.5" value="{{ old('comision') }}">
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
                                                {{ old('tipo') == $tipos_propiedad->id ? 'selected' : '' }}>
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
                                                {{ old('disponible_para') == $disponible_para->id ? 'selected' : '' }}>
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
                                                {{ old('estadopropiedad') == $estado_propiedad->id ? 'selected' : '' }}>
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
                                                {{ old('habitaciones') == (string) $i ? 'selected' : '' }}>
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
                                                {{ old('banos') == $banio ? 'selected' : '' }}>{{ $banio }}
                                            </option>
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
                                                {{ old('parqueos') == (string) $i ? 'selected' : '' }}>{{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label for="metraje" class="font-weight-bold">Metraje <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('metraje') is-invalid @enderror"
                                        id="metraje" name="metraje" placeholder="Ej: 185"
                                        value="{{ old('metraje') }}" required>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label for="metraje_construccion" class="font-weight-bold">Metraje
                                        construccion</label>
                                    <input type="text"
                                        class="form-control @error('metraje_construccion') is-invalid @enderror"
                                        id="metraje_construccion" name="metraje_construccion" placeholder="Ej: 160"
                                        value="{{ old('metraje_construccion') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4 property-section-amenities">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                                <h2 class="section-title mb-0">Amenidades y estado</h2>
                                <small class="text-muted">Selecciona solo las que apliquen</small>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <label class="toggle-chip">
                                    <input type="checkbox" name="destacada" id="destacada"
                                        {{ old('destacada') ? 'checked' : '' }}>
                                    <span>Destacada</span>
                                </label>
                                <label class="toggle-chip">
                                    <input type="checkbox" name="vendida" id="vendida"
                                        {{ old('vendida') ? 'checked' : '' }}>
                                    <span>Vendida</span>
                                </label>
                                <label class="toggle-chip">
                                    <input type="checkbox" name="marcadeagua" id="marcadeagua"
                                        {{ old('marcadeagua', 0) ? 'checked' : '' }}>
                                    <span>Aplicar marca de agua del logo</span>
                                </label>
                            </div>

                            <div class="row">
                                @foreach ($amenities as $key => $label)
                                    <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                                        <label class="toggle-chip w-100 mb-0">
                                            <input type="checkbox" name="{{ $key }}" id="{{ $key }}"
                                                {{ old($key) ? 'checked' : '' }}>
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

                            {{-- Foto Portada con Dropzone --}}
                            <div class="form-group mb-4">
                                <label class="font-weight-bold d-block mb-2">Foto principal <span
                                        class="text-danger">*</span></label>
                                <div id="dropzone-portada"
                                    class="dropzone-container dropzone-cover @error('foto_portada') is-invalid @enderror"
                                    style="border: 2px dashed #b7d1d8; border-radius: 0.75rem; padding: 2rem; text-align: center; cursor: pointer; background: #fafbfc; transition: all 0.3s ease;">
                                    <div class="dz-message">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" class="text-muted mb-2"
                                            style="display: inline-block; color: #6c757d;">
                                            <path d="M12 2v20M2 12h20" />
                                            <path d="M7 7l5-5 5 5M7 17l5 5 5-5" />
                                        </svg>
                                        <p class="text-muted mb-1"><strong>Arrastra aqui o haz clic</strong></p>
                                        <p class="text-muted" style="font-size: 0.85rem;">Horizontal, alta calidad (JPG,
                                            PNG, WebP)</p>
                                    </div>
                                </div>
                                <input type="file" id="foto_portada_input" name="foto_portada" class="d-none"
                                    accept="image/*">
                                <div id="gallery-file-inputs" class="d-none" aria-hidden="true"></div>
                                <small class="form-text text-muted d-block mt-2">Recomendada: 1200x800px o mayor,
                                    horizontal.</small>
                            </div>

                            {{-- Galeria adicional con Dropzone --}}
                            <div class="form-group mb-3">
                                <label class="font-weight-bold d-block mb-2">Galeria (opcionales)</label>
                                <div id="dropzone-gallery" class="dropzone-container dropzone-gallery"
                                    style="border: 2px dashed #d4d9e0; border-radius: 0.75rem; padding: 1.5rem; text-align: center; cursor: pointer; background: #f8f9fa; transition: all 0.3s ease;">
                                    <div class="dz-message">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" class="text-muted mb-2"
                                            style="display: inline-block; color: #6c757d;">
                                            <rect x="3" y="3" width="18" height="18" rx="2" />
                                            <circle cx="8.5" cy="8.5" r="1.5" />
                                            <path d="M21 15l-5-5L5 21" />
                                        </svg>
                                        <p class="text-muted mb-1" style="font-size: 0.9rem;"><strong>Arrastra
                                                fotos</strong></p>
                                        <p class="text-muted" style="font-size: 0.8rem;">Hasta 8 fotos adicionales</p>
                                    </div>
                                </div>
                                <small class="form-text text-muted d-block mt-2">Cargadas: <span
                                        id="gallery-count">0</span>/8</small>
                            </div>

                            {{-- Vista previa de galeria --}}
                            <div id="gallery-preview" class="d-grid gap-2"
                                style="grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));">
                            </div>

                            <hr class="my-3">

                            {{-- Video de YouTube --}}
                            <div class="form-group mb-0">
                                <label for="video1" class="font-weight-bold">Video de YouTube</label>
                                <input class="form-control" type="text" id="video1" name="video1"
                                    value="{{ old('video1') }}" placeholder="https://www.youtube.com/watch?v=...">
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
                                    placeholder="Descripcion para buscadores (20-160 caracteres)">{{ old('metadescription') }}</textarea>
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
                        <button type="submit" class="btn btn-primary btn-lg">Guardar Propiedad</button>
                        <a href="{{ route('propiedades.index') }}" class="btn btn-light border">Cancelar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- CKEditor 5 CDN (Secure & Modern) --}}
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

        .property-form-sections {
            display: flex;
            flex-direction: column;
        }

        .property-section-commercial {
            order: 1;
        }

        .property-section-amenities {
            order: 2;
        }

        .property-section-main {
            order: 3;
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

        /* Dropzone Styles */
        .dropzone-container {
            position: relative;
            overflow: hidden;
        }

        .dropzone-container.dz-clickable {
            cursor: pointer;
        }

        .dropzone-container.dz-clickable:hover {
            background-color: #f5f7fa !important;
            border-color: #b66a20 !important;
        }

        .dropzone-container.dz-drag-hover {
            background-color: #e8f4f7 !important;
            border-color: var(--brand-700) !important;
        }

        .dz-preview {
            position: relative;
            display: inline-block;
            margin: 0.5rem;
            border-radius: 0.5rem;
            overflow: hidden;
            background: #fff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .dz-preview:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .dz-preview img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dz-preview .dz-details {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s ease;
        }

        .dz-preview:hover .dz-details {
            opacity: 1;
        }

        .dz-preview .dz-remove {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 2.5rem;
            height: 2.5rem;
            padding: 0;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: bold;
            transition: all 0.2s ease;
        }

        .dz-preview .dz-remove:hover {
            background: #c82333;
            transform: translate(-50%, -50%) scale(1.1);
        }

        .dz-preview.dz-processing .dz-progress {
            display: block;
        }

        .dz-preview .dz-progress {
            display: none;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: rgba(0, 0, 0, 0.1);
        }

        .dz-preview .dz-progress .dz-upload {
            display: block;
            height: 100%;
            width: 0%;
            background: var(--accent-600);
            transition: width 0.3s ease;
        }

        .dz-error-mark,
        .dz-success-mark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            font-size: 2rem;
        }

        .dz-preview.dz-error .dz-error-mark {
            display: block;
        }

        .dz-preview.dz-success .dz-success-mark {
            display: block;
        }

        .gallery-preview-item {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
            overflow: hidden;
            border-radius: 0.5rem;
            background: #f5f7fa;
        }

        .gallery-preview-item img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Altura visible para CKEditor 5 en Descripcion completa */
        .ck-editor__editable_inline {
            min-height: 320px;
        }

        @media (max-width: 1199.98px) {
            .sticky-media-card {
                position: static;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@6.0.0-beta.1/dist/dropzone-min.css">

    <script>
        // Deshabilitamos autoDiscover de Dropzone para control manual
        Dropzone.autoDiscover = false;

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

            const fallbackMatch = rawValue.match(/(?:v=|\/embed\/|youtu\.be\/|\/shorts\/)([a-zA-Z0-9_-]{11})/);
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

        const aiButton = document.getElementById('btn-generar-ia-propiedad');
        const aiInstructions = document.getElementById('ia_instrucciones_propiedad');
        const tituloField = document.getElementById('titulo');
        const descripcionField = document.getElementById('descripcion');
        const descripcionCortaField = document.getElementById('descripcion_corta');
        const metaField = document.getElementById('metadescription');
        const requiredCommercialSelects = [{
                id: 'provincia',
                label: 'Provincia'
            },
            {
                id: 'sector_id',
                label: 'Sector'
            },
            {
                id: 'tipomoneda',
                label: 'Moneda'
            },
            {
                id: 'tipo',
                label: 'Tipo de propiedad'
            },
            {
                id: 'disponible_para',
                label: 'Disponible para'
            },
            {
                id: 'estadopropiedad',
                label: 'Estado de propiedad'
            },
            {
                id: 'habitaciones',
                label: 'Habitaciones'
            },
            {
                id: 'banos',
                label: 'Banos'
            },
            {
                id: 'parqueos',
                label: 'Parqueos'
            },
        ];
        const nonAmenityToggleIds = new Set(['destacada', 'vendida', 'activa', 'aprobada', 'marcadeagua']);

        const getEditorContent = () => {
            if (window.__propiedadDescripcionEditor) {
                return window.__propiedadDescripcionEditor.getData() || '';
            }

            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances && CKEDITOR.instances.descripcion) {
                return CKEDITOR.instances.descripcion.getData() || '';
            }

            return descripcionField?.value || '';
        };

        const setEditorContent = (value) => {
            if (window.__propiedadDescripcionEditor) {
                window.__propiedadDescripcionEditor.setData(value || '');
            }

            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances && CKEDITOR.instances.descripcion) {
                CKEDITOR.instances.descripcion.setData(value || '');
            }

            if (descripcionField) {
                descripcionField.value = value || '';
            }
        };

        const selectedText = (selectId) => {
            const select = document.getElementById(selectId);
            if (!select || select.selectedIndex < 0) {
                return '';
            }

            return (select.options[select.selectedIndex]?.text || '').trim();
        };

        const getSelectedAmenities = () => Array.from(document.querySelectorAll(
                '.toggle-chip input[type="checkbox"]:checked'))
            .filter((item) => !nonAmenityToggleIds.has(item.id))
            .map((item) => item.parentElement?.innerText?.trim())
            .filter(Boolean);

        const validateAiPrerequisites = () => {
            const missingCommercialSelections = requiredCommercialSelects.filter((field) => {
                const select = document.getElementById(field.id);
                return !select || !String(select.value || '').trim();
            });

            const selectedAmenities = getSelectedAmenities();

            if (!missingCommercialSelections.length && selectedAmenities.length > 0) {
                return {
                    ok: true,
                    selectedAmenities,
                };
            }

            const warnings = [];
            if (missingCommercialSelections.length) {
                warnings.push(
                    `<strong>Datos comerciales:</strong> ${missingCommercialSelections.map((item) => item.label).join(', ')}`
                );
            }

            if (selectedAmenities.length === 0) {
                warnings.push('<strong>Amenidades y estado:</strong> selecciona al menos una amenidad.');
            }

            if (window.Swal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Completa el contexto antes de usar IA',
                    html: warnings.join('<br>'),
                    confirmButtonText: 'Entendido',
                });
            }

            if (missingCommercialSelections.length) {
                document.getElementById(missingCommercialSelections[0].id)?.focus();
            } else {
                document.querySelector(
                    '.toggle-chip input[type="checkbox"]:not(#destacada):not(#vendida):not(#activa):not(#aprobada)'
                )?.focus();
            }

            return {
                ok: false,
                selectedAmenities,
            };
        };

        const provinciaSelect = document.getElementById('provincia');
        const sectorSelect = document.getElementById('sector_id');
        const allSectorOptions = sectorSelect ? Array.from(sectorSelect.options).map((option) => ({
            value: option.value,
            text: option.text,
            provincia: option.dataset.provincia || ''
        })) : [];

        const refreshSectorOptions = () => {
            if (!provinciaSelect || !sectorSelect) {
                return;
            }

            const provinciaValue = provinciaSelect.value;
            const currentValue = sectorSelect.value;
            let hasCurrent = false;

            sectorSelect.innerHTML = '';

            allSectorOptions.forEach((item) => {
                if (item.value && provinciaValue && item.provincia !== provinciaValue) {
                    return;
                }

                const option = document.createElement('option');
                option.value = item.value;
                option.text = item.text;

                if (item.provincia) {
                    option.dataset.provincia = item.provincia;
                }

                if (item.value && item.value === currentValue) {
                    option.selected = true;
                    hasCurrent = true;
                }

                sectorSelect.appendChild(option);
            });

            if (!hasCurrent) {
                sectorSelect.value = '';
            }
        };

        provinciaSelect?.addEventListener('change', refreshSectorOptions);
        refreshSectorOptions();

        if (aiButton) {
            const endpoint = '{{ route('admin.ai.generate') }}';
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            aiButton.addEventListener('click', async () => {
                const aiPrerequisites = validateAiPrerequisites();
                if (!aiPrerequisites.ok) {
                    return;
                }

                const checkedAmenities = aiPrerequisites.selectedAmenities;

                const contexto = {
                    titulo: tituloField?.value || '',
                    descripcion_actual: getEditorContent(),
                    descripcion_corta_actual: descripcionCortaField?.value || '',
                    metadescription_actual: metaField?.value || '',
                    provincia: selectedText('provincia'),
                    sector: selectedText('sector_id'),
                    tipo_propiedad: selectedText('tipo'),
                    disponible_para: selectedText('disponible_para'),
                    estado: selectedText('estadopropiedad'),
                    moneda: selectedText('tipomoneda'),
                    precio: document.getElementById('precio')?.value || '',
                    habitaciones: document.getElementById('habitaciones')?.value || '',
                    banos: document.getElementById('banos')?.value || '',
                    parqueos: document.getElementById('parqueos')?.value || '',
                    metraje: document.getElementById('metraje')?.value || '',
                    metraje_construccion: document.getElementById('metraje_construccion')?.value || '',
                    amenidades: checkedAmenities,
                };

                aiButton.disabled = true;
                const aiSpinner = document.getElementById('ia-propiedad-spinner');
                const aiLabel = document.getElementById('ia-propiedad-label');
                if (aiSpinner) aiSpinner.classList.remove('d-none');
                if (aiLabel) aiLabel.textContent = 'Generando...';

                try {
                    const response = await fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            type: 'inmueble',
                            instrucciones: aiInstructions?.value || '',
                            contexto,
                        }),
                    });

                    const result = await response.json();
                    if (!response.ok || !result.ok) {
                        throw new Error(result.message || 'No fue posible generar contenido.');
                    }

                    const data = result.data || {};
                    if (data.titulo_sugerido && tituloField) {
                        tituloField.value = data.titulo_sugerido;
                    }

                    if (data.descripcion) {
                        setEditorContent(data.descripcion);
                    }

                    if (data.descripcion_corta && descripcionCortaField) {
                        descripcionCortaField.value = data.descripcion_corta;
                    }

                    if (data.metadescription && metaField) {
                        metaField.value = data.metadescription;
                    }

                    if (window.Swal) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Textos generados',
                            text: 'Revisa y ajusta antes de guardar.',
                            timer: 1800,
                            showConfirmButton: false,
                        });
                    }
                } catch (error) {
                    if (window.Swal) {
                        Swal.fire('Error', error.message || 'No fue posible generar contenido con IA.',
                            'error');
                    }
                } finally {
                    aiButton.disabled = false;
                    if (aiSpinner) aiSpinner.classList.add('d-none');
                    if (aiLabel) aiLabel.textContent = 'Generar textos con IA';
                }
            });
        }

        // Almacenamiento temporal de archivos seleccionados en Dropzone
        let galleryFiles = [];
        let coverFile = null;
        const coverFileInput = document.getElementById('foto_portada_input');
        const galleryInputsContainer = document.getElementById('gallery-file-inputs');
        const coverDropzone = document.getElementById('dropzone-portada');

        function assignFileToInput(input, file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
        }

        function syncCoverFileInput() {
            if (!coverFileInput) {
                return;
            }

            if (!coverFile) {
                coverFileInput.value = '';
                return;
            }

            assignFileToInput(coverFileInput, coverFile);
        }

        function syncGalleryFileInputs() {
            if (!galleryInputsContainer) {
                return;
            }

            galleryInputsContainer.innerHTML = '';

            const galleryArray = galleryFiles.slice(0, 8);

            galleryArray.forEach((file, index) => {
                const input = document.createElement('input');
                input.type = 'file';
                input.name = `foto${index + 1}`;
                input.className = 'd-none';
                galleryInputsContainer.appendChild(input);
                assignFileToInput(input, file);
            });
        }

        function setCoverInvalidState(isInvalid) {
            if (!coverDropzone) {
                return;
            }

            const feedbackId = 'foto-portada-feedback';
            const existingFeedback = document.getElementById(feedbackId);

            if (isInvalid) {
                coverDropzone.classList.add('is-invalid');

                if (!existingFeedback) {
                    const feedback = document.createElement('div');
                    feedback.id = feedbackId;
                    feedback.className = 'invalid-feedback d-block mt-2';
                    feedback.textContent = 'Se requiere una foto principal';
                    coverDropzone.parentElement.appendChild(feedback);
                }
            } else {
                coverDropzone.classList.remove('is-invalid');
                if (existingFeedback) {
                    existingFeedback.remove();
                }
            }
        }

        // Inicializar Dropzone para Foto Portada
        const dzCover = new Dropzone('#dropzone-portada', {
            url: '#',
            paramName: 'file',
            maxFiles: 1,
            maxFilesize: 10,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            previewTemplate: `
            <div class="dz-preview dz-file-preview" style="width: 100%; height: 200px;">
                <img data-dz-thumbnail src="" alt="Preview">
                <div class="dz-details">
                    <button class="dz-remove btn btn-sm btn-danger" type="button">Eliminar</button>
                </div>
                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
            </div>
        `,
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                    coverFile = file;
                    syncCoverFileInput();
                    setCoverInvalidState(false);

                    // Preview inmediato
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        file.dataURL = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });

                this.on('removedfile', function(file) {
                    if (file === coverFile) {
                        coverFile = null;
                        syncCoverFileInput();
                    }
                });
            }
        });

        // Inicializar Dropzone para Galería
        const dzGallery = new Dropzone('#dropzone-gallery', {
            url: '#',
            paramName: 'file',
            maxFiles: 8,
            maxFilesize: 10,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            previewTemplate: `
            <div class="dz-preview dz-file-preview" style="width: 70px; height: 70px;">
                <img data-dz-thumbnail src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                <div class="dz-details">
                    <button class="dz-remove btn btn-sm btn-danger" type="button" style="padding: 0.25rem 0.5rem; font-size: 0.7rem;">X</button>
                </div>
                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
            </div>
        `,
            init: function() {
                this.on('addedfile', function(file) {
                    galleryFiles.push(file);
                    updateGalleryCount();
                    syncGalleryFileInputs();
                });

                this.on('removedfile', function(file) {
                    galleryFiles = galleryFiles.filter((galleryFile) => galleryFile !== file);
                    updateGalleryCount();
                    syncGalleryFileInputs();
                });
            }
        });

        function updateGalleryCount() {
            const count = galleryFiles.length;
            const countEl = document.getElementById('gallery-count');
            if (countEl) {
                countEl.textContent = count;
            }
        }

        // Sincronizar archivos Dropzone con inputs file reales antes de enviar
        const propertyForm = document.querySelector('form[action*="propiedades.store"]') || document.querySelector('form');

        function clearClientValidationErrors() {
            document.querySelectorAll('.js-client-invalid').forEach((element) => {
                element.classList.remove('is-invalid', 'js-client-invalid');
            });

            document.querySelectorAll('.js-client-feedback').forEach((element) => {
                element.remove();
            });
        }

        function showFormErrors(errors) {
            const errorsContainer = document.getElementById('property-form-errors');
            const errorsList = document.getElementById('property-form-errors-list');

            if (!errorsContainer || !errorsList) {
                return;
            }

            errorsList.innerHTML = '';

            Object.values(errors).flat().forEach((message) => {
                const item = document.createElement('li');
                item.textContent = message;
                errorsList.appendChild(item);
            });

            errorsContainer.classList.remove('d-none');
            errorsContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function setFieldInvalid(fieldName, message) {
            if (!propertyForm || fieldName === 'foto_portada') {
                return;
            }

            const field = propertyForm.querySelector(`[name="${fieldName}"]`);

            if (!field) {
                return;
            }

            field.classList.add('is-invalid', 'js-client-invalid');

            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback d-block js-client-feedback';
            feedback.textContent = message;
            field.insertAdjacentElement('afterend', feedback);
        }

        async function submitPropertyForm(event) {
            event.preventDefault();

            clearClientValidationErrors();
            syncCoverFileInput();
            syncGalleryFileInputs();

            const errorsContainer = document.getElementById('property-form-errors');
            if (errorsContainer) {
                errorsContainer.classList.add('d-none');
            }

            if (!coverFile || !coverFileInput || !coverFileInput.files.length) {
                setCoverInvalidState(true);
                showFormErrors({
                    foto_portada: ['Se requiere una foto principal']
                });
                return false;
            }

            setCoverInvalidState(false);

            if (window.__propiedadDescripcionEditor) {
                const descripcionField = document.getElementById('descripcion');
                if (descripcionField) {
                    descripcionField.value = window.__propiedadDescripcionEditor.getData();
                }
            }

            const submitButton = propertyForm.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
            }

            try {
                const formData = new FormData(propertyForm);
                const response = await fetch(propertyForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (response.ok) {
                    if (response.redirected && response.url) {
                        window.location.href = response.url;
                        return true;
                    }

                    window.location.reload();
                    return true;
                }

                if (response.status === 422) {
                    const payload = await response.json();
                    const errors = payload.errors || {};

                    showFormErrors(errors);
                    Object.entries(errors).forEach(([fieldName, fieldErrors]) => {
                        if (fieldName === 'foto_portada') {
                            setCoverInvalidState(true);
                        }

                        if (Array.isArray(fieldErrors) && fieldErrors.length > 0) {
                            setFieldInvalid(fieldName, fieldErrors[0]);
                        }
                    });

                    return false;
                }

                showFormErrors({
                    general: ['No fue posible guardar la propiedad. Intenta nuevamente.']
                });
                return false;
            } catch (error) {
                showFormErrors({
                    general: ['Error de conexion. Revisa tu red e intenta nuevamente.']
                });
                return false;
            } finally {
                if (submitButton) {
                    submitButton.disabled = false;
                }
            }
        }

        if (propertyForm) {
            propertyForm.addEventListener('submit', submitPropertyForm);
        }

        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.descripcion) {
            // CKEditor 5 ya está inicializado
        } else if (typeof ClassicEditor !== 'undefined') {
            // Inicializar CKEditor 5
            ClassicEditor
                .create(document.querySelector('#descripcion'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Párrafo',
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
                .then(editor => {
                    window.__propiedadDescripcionEditor = editor;
                    editor.editing.view.change(writer => {
                        writer.setStyle('min-height', '320px', editor.editing.view.document.getRoot());
                    });
                })
                .catch(error => {
                    console.error('CKEditor 5 error:', error);
                });
        }
    </script>
@endsection
