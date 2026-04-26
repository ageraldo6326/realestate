@extends('layout.layout-landing')

@section('seo_title', $propiedad->titulo . ' - ' . ($inmobiliaria->titulo ?? 'Portal Inmobiliario'))
@section('seo_description', $propiedad->metadescription ?? ($propiedad->metadescripcion ??
    $propiedad->descripcion_corta))

@section('extra_styles')
    <link rel="stylesheet" href="{{ asset('css/property-detail.css') }}">
@endsection

@section('content')
    @php
        $images = collect([
            $propiedad->foto_portada,
            $propiedad->foto1,
            $propiedad->foto2,
            $propiedad->foto3,
            $propiedad->foto4,
            $propiedad->foto5,
            $propiedad->foto6,
            $propiedad->foto7,
            $propiedad->foto8,
        ])
            ->filter(function ($image) {
                return !empty($image);
            })
            ->values();

        $telefonoAsesor = $usuario->telefono ?? ($inmobiliaria->telefono ?? '');
        $whatsAppMessage = ($propiedad->descripcion_corta ?: $propiedad->titulo) . ' ' . url()->current();
        $whatsAppUrl = $telefonoAsesor
            ? 'https://api.whatsapp.com/send/?phone=' . $telefonoAsesor . '&text=' . urlencode($whatsAppMessage)
            : null;

        $amenities = [
            'lobby' => 'Lobby',
            'plantaelectrica' => 'Planta eléctrica',
            'camaravigilancia' => 'Cámara de vigilancia',
            'escaleraemergencia' => 'Escalera de emergencia',
            'maderapreciosa' => 'Madera preciosa',
            'balcon' => 'Balcón',
            'walkincloset' => 'Walk in closet',
            'jacuzzi' => 'Jacuzzi',
            'areainfantil' => 'Área infantil',
            'banovisitas' => 'Baño de visitas',
            'cisterna' => 'Cisterna',
            'inversorareacomun' => 'Inversor área común',
            'gascomun' => 'Gas común',
            'gazebo' => 'Gazebo',
            'pozo' => 'Pozo',
            'piscina' => 'Piscina',
            'familyroom' => 'Family room',
            'cuartodeservicio' => 'Cuarto de servicio',
            'patio' => 'Patio',
            'portonelectrico' => 'Portón eléctrico',
            'seguridad24horas' => 'Seguridad 24 horas',
            'ascensor' => 'Ascensor',
            'parqueostechados' => 'Parqueos techados',
            'preinstalacionairetinacoinversor' => 'Preinstalación aire y tinaco',
            'terraza' => 'Terraza',
            'estudio' => 'Estudio',
            'gimnasio' => 'Gimnasio',
            'controldeacceso' => 'Control de acceso',
        ];
    @endphp

    <!-- Breadcrumb -->
    <nav aria-label="Navegación" class="breadcrumb-nav py-3 bg-light">
        <div class="container-lg">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('listapropiedades') }}">Propiedades</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $propiedad->titulo }}</li>
            </ol>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="property-hero bg-gradient-dark text-white py-5">
        <div class="container-lg">
            <div class="d-flex flex-column gap-2">
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge bg-primary">{{ $propiedad->estado }}</span>
                    <span class="badge bg-success">{{ $propiedad->disponible_para }}</span>
                </div>
                <h1 class="h3 mb-2">{{ $propiedad->titulo }}</h1>
                <p class="text-white-75 mb-0">
                    <i class="fas fa-map-marker-alt"></i> {{ $propiedad->zona }} |
                    <i class="fas fa-building"></i> {{ $propiedad->tipo }} |
                    <span class="text-accent fw-bold">{{ $propiedad->Moneda }}
                        {{ number_format($propiedad->precio ?? 0, 2) }}</span>
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="property-detail py-5 bg-body-secondary">
        <div class="container-lg">
            <div class="row g-4">

                <!-- Main Column -->
                <div class="col-lg-8">

                    <!-- Gallery Card -->
                    @if ($images->isNotEmpty())
                        <article class="card shadow-sm mb-4 border-0">
                            <div class="card-body p-0 position-relative overflow-hidden">
                                <div id="propertyGallery" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($images as $index => $image)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img loading="lazy" src="{{ asset('assets/' . $image) }}"
                                                    alt="{{ $propiedad->titulo }}" title="{{ $propiedad->titulo }}"
                                                    class="w-100 d-block" style="height: 400px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>

                                    @if ($images->count() > 1)
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#propertyGallery" data-bs-slide="prev"
                                            aria-label="Imagen anterior">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#propertyGallery" data-bs-slide="next"
                                            aria-label="Imagen siguiente">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        </button>
                                    @endif
                                </div>

                                <!-- Thumbnails -->
                                @if ($images->count() > 1)
                                    <div class="d-flex gap-2 p-3 overflow-x-auto bg-light">
                                        @foreach ($images as $index => $image)
                                            <button type="button" data-bs-target="#propertyGallery"
                                                data-bs-slide-to="{{ $index }}"
                                                class="btn btn-sm p-0 border-2 border-transparent flex-shrink-0"
                                                style="width: 80px; height: 60px;"
                                                aria-label="Ir a imagen {{ $index + 1 }}">
                                                <img loading="lazy" src="{{ asset('assets/' . $image) }}"
                                                    alt="Miniatura {{ $index + 1 }}" class="w-100 h-100"
                                                    style="object-fit: cover;">
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endif

                    <!-- Description Card -->
                    <article class="card shadow-sm mb-4 border-0">
                        <div class="card-body">
                            <h2 class="card-title h5 mb-3">Descripción</h2>
                            <div class="text-muted mb-4">
                                {!! $propiedad->descripcion !!}
                            </div>

                            @if ($whatsAppUrl)
                                <a href="{{ $whatsAppUrl }}" target="_blank" rel="noopener noreferrer"
                                    class="btn btn-success btn-lg w-100">
                                    <i class="fab fa-whatsapp me-2"></i>
                                    Contactar asesor por WhatsApp
                                </a>
                            @endif
                        </div>
                    </article>

                    <!-- Property Details Card -->
                    <article class="card shadow-sm mb-4 border-0">
                        <div class="card-body">
                            <h2 class="card-title h5 mb-3">Detalles de la propiedad</h2>
                            <div class="row g-2">
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Referencia</small>
                                        <strong>{{ $propiedad->referencia ?: '-' }}</strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Precio</small>
                                        <strong>{{ $propiedad->Moneda }}
                                            {{ number_format($propiedad->precio ?? 0, 2) }}</strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Metraje total</small>
                                        <strong>{{ $propiedad->metraje ? $propiedad->metraje . ' m²' : '-' }}</strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Construcción</small>
                                        <strong>{{ $propiedad->metraje_construccion ? $propiedad->metraje_construccion . ' m²' : '-' }}</strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Habitaciones</small>
                                        <strong>{{ $propiedad->habitaciones ?? '-' }}</strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Baños</small>
                                        <strong>{{ $propiedad->banos ?? '-' }}</strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Parqueos</small>
                                        <strong>{{ $propiedad->parqueos ?? '-' }}</strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Disponible para</small>
                                        <strong>{{ $propiedad->disponible_para ?: '-' }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <!-- Amenities Card -->
                    <article class="card shadow-sm mb-4 border-0">
                        <div class="card-body">
                            <h2 class="card-title h5 mb-3">Características y amenidades</h2>
                            <div class="row g-2">
                                @foreach ($amenities as $field => $label)
                                    @php
                                        $hasAmenity = !empty($propiedad->$field);
                                    @endphp
                                    <div class="col-6 col-md-4">
                                        <div
                                            class="amenity-item p-2 rounded border {{ $hasAmenity ? 'border-success bg-success bg-opacity-10' : 'border-light' }}">
                                            <i
                                                class="fa-solid {{ $hasAmenity ? 'fa-circle-check text-success' : 'fa-circle text-muted' }} me-2"></i>
                                            <span
                                                class="small {{ $hasAmenity ? 'text-dark fw-500' : 'text-muted' }}">{{ $label }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </article>

                    <!-- Video Card -->
                    @if (!empty($propiedad->video1))
                        <article class="card shadow-sm mb-4 border-0">
                            <div class="card-body">
                                <h2 class="card-title h5 mb-3">Video de la propiedad</h2>
                                <div class="ratio ratio-16x9 rounded overflow-hidden">
                                    <iframe src="{{ 'https://www.youtube.com/embed/' . $propiedad->video1 }}"
                                        title="Video de {{ $propiedad->titulo }}" allowfullscreen loading="lazy">
                                    </iframe>
                                </div>
                            </div>
                        </article>
                    @endif

                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">

                    <!-- Agent Card (Sticky) -->
                    <aside class="agent-card card shadow-sm border-0 sticky-lg-top mb-4" style="top: 20px;">
                        <div class="card-body text-center">
                            <img class="rounded-circle mb-3"
                                src="{{ asset('assets/' . ($usuario->foto ?? 'user.png')) }}"
                                alt="{{ $usuario->name ?? 'Asesor inmobiliario' }}"
                                title="{{ $usuario->name ?? 'Asesor inmobiliario' }}" loading="lazy"
                                style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #f0ad4e;">

                            <h3 class="h6 mb-1">{{ $usuario->name ?? 'Asesor inmobiliario' }}</h3>
                            @if ($usuario->email ?? false)
                                <p class="text-muted small mb-2">
                                    <a href="mailto:{{ $usuario->email }}" class="text-decoration-none">
                                        {{ $usuario->email }}
                                    </a>
                                </p>
                            @endif

                            <div class="d-grid gap-2">
                                @if ($whatsAppUrl)
                                    <a href="{{ $whatsAppUrl }}" target="_blank" rel="noopener noreferrer"
                                        class="btn btn-success btn-sm">
                                        <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                    </a>
                                @endif
                                @if ($usuario->telefono ?? false)
                                    <a href="tel:{{ $usuario->telefono }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-phone me-1"></i> Llamar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </aside>

                    <!-- Property Summary Card -->
                    <aside class="summary-card card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h3 class="card-title h6 mb-3">Información rápida</h3>
                            <dl class="row mb-0 small">
                                <dt class="col-7 text-muted">Estado:</dt>
                                <dd class="col-5 text-end"><strong>{{ $propiedad->estado }}</strong></dd>

                                <dt class="col-7 text-muted">Tipo:</dt>
                                <dd class="col-5 text-end"><strong>{{ $propiedad->tipo }}</strong></dd>

                                <dt class="col-7 text-muted">Zona:</dt>
                                <dd class="col-5 text-end"><strong>{{ $propiedad->zona }}</strong></dd>

                                <dt class="col-7 text-muted">Año publicado:</dt>
                                <dd class="col-5 text-end"><strong>
                                        @if ($propiedad->created_at)
                                            {{ date('Y', strtotime($propiedad->created_at)) }}@else-
                                        @endif
                                    </strong></dd>
                            </dl>
                        </div>
                    </aside>

                    <!-- Share Card -->
                    <aside class="share-card card shadow-sm border-0">
                        <div class="card-body">
                            <h3 class="card-title h6 mb-3">Compartir propiedad</h3>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                    target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary btn-sm"
                                    aria-label="Compartir en Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($propiedad->titulo) }}"
                                    target="_blank" rel="noopener noreferrer" class="btn btn-outline-info btn-sm"
                                    aria-label="Compartir en Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                                    target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary btn-sm"
                                    aria-label="Compartir en LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                    onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('Link copiado')"
                                    aria-label="Copiar enlace">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>
                    </aside>

                </div>

            </div>
        </div>
    </main>

    <!-- Related Properties Section -->
    @if (!$propiedades_relacionadas->isEmpty())
        <section class="related-properties py-5 bg-light">
            <div class="container-lg">
                <h2 class="h4 mb-4">Propiedades relacionadas</h2>
                <div class="row g-4">
                    @foreach ($propiedades_relacionadas as $prop)
                        <div class="col-md-6 col-lg-6">
                            <div class="card shadow-sm border-0 h-100 overflow-hidden transition-all"
                                style="transition: transform 0.3s ease;">
                                <a href="{{ route('propiedad', $prop->slug) }}" class="text-decoration-none text-dark">
                                    <div class="position-relative overflow-hidden" style="height: 200px;">
                                        <img loading="lazy"
                                            src="{{ asset('assets/' . ($prop->foto_portada ?? 'placeholder.jpg')) }}"
                                            alt="{{ $prop->titulo }}" class="w-100 h-100"
                                            style="object-fit: cover; transition: transform 0.3s ease;">
                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge bg-primary">{{ $prop->estado }}</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <h3 class="card-title h6 mb-2">{{ $prop->titulo }}</h3>
                                        <p class="text-muted small mb-2">
                                            <i class="fas fa-map-marker-alt"></i> {{ $prop->zona }}
                                        </p>
                                        <div class="row g-2 mb-3 small">
                                            <div class="col-6">
                                                <span class="text-muted"><i class="fas fa-door-open"></i>
                                                    {{ $prop->habitaciones ?? '-' }}</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted"><i class="fas fa-bath"></i>
                                                    {{ $prop->banos ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="text-primary">{{ $prop->Moneda }}
                                                {{ number_format($prop->precio ?? 0, 2) }}</strong>
                                            <small
                                                class="text-muted">{{ $prop->metraje ? $prop->metraje . ' m²' : '-' }}</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
