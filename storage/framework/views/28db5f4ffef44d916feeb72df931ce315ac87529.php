

<?php $__env->startSection('seo_title', $propiedad->titulo . ' - ' . ($inmobiliaria->titulo ?? 'Portal Inmobiliario')); ?>
<?php $__env->startSection('seo_description', $propiedad->metadescription ?? ($propiedad->metadescripcion ??
    $propiedad->descripcion_corta)); ?>

<?php $__env->startSection('extra_styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/property-detail.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $propertyPlaceholder = asset('assets/prop-apto-1.jpg');
        $agentPlaceholder = asset('vendor/adminlte/dist/img/user2-160x160.jpg');
        $resolvePropertyImage = function ($value, $version = null, $fallback = null) {
            $fallback ??= asset('assets/prop-apto-1.jpg');

            if (empty($value)) {
                return $fallback;
            }

            $appendVersion = function (string $url) use ($version): string {
                if (!$version) {
                    return $url;
                }

                $separator = str_contains($url, '?') ? '&' : '?';

                return $url . $separator . 'v=' . rawurlencode((string) $version);
            };

            if (\Illuminate\Support\Str::startsWith($value, ['http://', 'https://', '//', 'data:'])) {
                return $appendVersion($value);
            }

            if (\Illuminate\Support\Str::startsWith($value, ['/img/', '/assets/', 'img/', 'assets/'])) {
                return $appendVersion(asset(ltrim($value, '/')));
            }

            return $appendVersion(asset('assets/' . ltrim($value, '/')));
        };
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

        $avatarSource = optional($usuario)->foto ?: $propiedad->foto_vendedor ?? '';
        if (!empty($avatarSource) && \Illuminate\Support\Str::startsWith($avatarSource, ['http://', 'https://'])) {
            $agentAvatarUrl = $avatarSource;
        } elseif (!empty($avatarSource) && \Illuminate\Support\Str::startsWith($avatarSource, '/')) {
            $agentAvatarUrl = asset(ltrim($avatarSource, '/'));
        } elseif (!empty($avatarSource)) {
            $agentAvatarUrl = asset('assets/' . ltrim($avatarSource, '/'));
        } else {
            $agentAvatarUrl = $agentPlaceholder;
        }

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
    ?>

    <!-- Breadcrumb -->
    <nav aria-label="Navegación" class="breadcrumb-nav py-3 bg-light">
        <div class="container-lg">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('listapropiedades')); ?>">Propiedades</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo e($propiedad->titulo); ?></li>
            </ol>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="property-hero bg-gradient-dark text-white py-5">
        <div class="container-lg">
            <div class="d-flex flex-column gap-2">
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge bg-primary"><?php echo e($propiedad->estado); ?></span>
                    <span class="badge bg-success"><?php echo e($propiedad->disponible_para); ?></span>
                </div>
                <h1 class="h3 mb-2"><?php echo e($propiedad->titulo); ?></h1>
                <p class="text-white-75 mb-0">
                    <i class="fas fa-map-marker-alt"></i> <?php echo e($propiedad->zona); ?> |
                    <i class="fas fa-building"></i> <?php echo e($propiedad->tipo); ?> |
                    <span class="text-accent fw-bold"><?php echo e($propiedad->Moneda); ?>

                        <?php echo e(number_format($propiedad->precio ?? 0, 2)); ?></span>
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
                    <?php if($images->isNotEmpty()): ?>
                        <article class="card shadow-sm mb-4 border-0">
                            <div class="card-body p-0 position-relative overflow-hidden">
                                <div id="propertyGallery" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                                                <img loading="lazy"
                                                    src="<?php echo e($resolvePropertyImage($image, optional($propiedad)->updated_at, $propertyPlaceholder)); ?>"
                                                    onerror="this.onerror=null;this.src='<?php echo e($propertyPlaceholder); ?>';"
                                                    alt="<?php echo e($propiedad->titulo); ?>" title="<?php echo e($propiedad->titulo); ?>"
                                                    class="w-100 d-block" style="height: 400px; object-fit: cover;">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                    <?php if($images->count() > 1): ?>
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
                                    <?php endif; ?>
                                </div>

                                <!-- Thumbnails -->
                                <?php if($images->count() > 1): ?>
                                    <div class="d-flex gap-2 p-3 overflow-x-auto bg-light">
                                        <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <button type="button" data-bs-target="#propertyGallery"
                                                data-bs-slide-to="<?php echo e($index); ?>"
                                                class="btn btn-sm p-0 border-2 border-transparent flex-shrink-0"
                                                style="width: 80px; height: 60px;"
                                                aria-label="Ir a imagen <?php echo e($index + 1); ?>">
                                                <img loading="lazy"
                                                    src="<?php echo e($resolvePropertyImage($image, optional($propiedad)->updated_at, $propertyPlaceholder)); ?>"
                                                    onerror="this.onerror=null;this.src='<?php echo e($propertyPlaceholder); ?>';"
                                                    alt="Miniatura <?php echo e($index + 1); ?>" class="w-100 h-100"
                                                    style="object-fit: cover;">
                                            </button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endif; ?>

                    <!-- Description Card -->
                    <article class="card shadow-sm mb-4 border-0">
                        <div class="card-body">
                            <h2 class="card-title h5 mb-3">Descripción</h2>
                            <div class="text-muted mb-4">
                                <?php echo $propiedad->descripcion; ?>

                            </div>

                            <?php if($whatsAppUrl): ?>
                                <a href="<?php echo e($whatsAppUrl); ?>" target="_blank" rel="noopener noreferrer"
                                    class="btn btn-success btn-lg w-100">
                                    <i class="fab fa-whatsapp me-2"></i>
                                    Contactar asesor por WhatsApp
                                </a>
                            <?php endif; ?>
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
                                        <strong><?php echo e($propiedad->referencia ?: '-'); ?></strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Precio</small>
                                        <strong><?php echo e($propiedad->Moneda); ?>

                                            <?php echo e(number_format($propiedad->precio ?? 0, 2)); ?></strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Metraje total</small>
                                        <strong><?php echo e($propiedad->metraje ? $propiedad->metraje . ' m²' : '-'); ?></strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Construcción</small>
                                        <strong><?php echo e($propiedad->metraje_construccion ? $propiedad->metraje_construccion . ' m²' : '-'); ?></strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Habitaciones</small>
                                        <strong><?php echo e($propiedad->habitaciones ?? '-'); ?></strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Baños</small>
                                        <strong><?php echo e($propiedad->banos ?? '-'); ?></strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Parqueos</small>
                                        <strong><?php echo e($propiedad->parqueos ?? '-'); ?></strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="detail-item p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1">Disponible para</small>
                                        <strong><?php echo e($propiedad->disponible_para ?: '-'); ?></strong>
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
                                <?php $__currentLoopData = $amenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $hasAmenity = !empty($propiedad->$field);
                                    ?>
                                    <div class="col-6 col-md-4">
                                        <div
                                            class="amenity-item p-2 rounded border <?php echo e($hasAmenity ? 'border-success bg-success bg-opacity-10' : 'border-light'); ?>">
                                            <i
                                                class="fa-solid <?php echo e($hasAmenity ? 'fa-circle-check text-success' : 'fa-circle text-muted'); ?> me-2"></i>
                                            <span
                                                class="small <?php echo e($hasAmenity ? 'text-dark fw-500' : 'text-muted'); ?>"><?php echo e($label); ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </article>

                    <!-- Video Card -->
                    <?php if(!empty($propiedad->video1)): ?>
                        <?php
                            $rawVideo = trim($propiedad->video1);
                            $videoId = $rawVideo;

                            if (str_contains($rawVideo, 'watch?v=')) {
                                parse_str(parse_url($rawVideo, PHP_URL_QUERY), $qs);
                                $videoId = $qs['v'] ?? $rawVideo;
                            } elseif (str_contains($rawVideo, 'youtu.be/')) {
                                $videoId = basename(parse_url($rawVideo, PHP_URL_PATH));
                            } elseif (str_contains($rawVideo, 'youtube.com/embed/')) {
                                $videoId = basename(parse_url($rawVideo, PHP_URL_PATH));
                            }

                            // Remove any leftover query string attached to the ID
                            $videoId = explode('?', $videoId)[0];
                            $videoId = explode('&', $videoId)[0];
                        ?>
                        <?php if(!empty($videoId)): ?>
                            <article class="card shadow-sm mb-4 border-0">
                                <div class="card-body">
                                    <h2 class="card-title h5 mb-3">Video de la propiedad</h2>
                                    <div class="ratio ratio-16x9 rounded overflow-hidden">
                                        <iframe src="https://www.youtube.com/embed/<?php echo e($videoId); ?>"
                                            title="Video de <?php echo e($propiedad->titulo); ?>" allowfullscreen loading="lazy">
                                        </iframe>
                                    </div>
                                </div>
                            </article>
                        <?php endif; ?>
                    <?php endif; ?>

                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">

                    <!-- Agent Card (Sticky) -->
                    <aside class="agent-card card shadow-sm border-0 sticky-lg-top mb-4" style="top: 20px;">
                        <div class="card-body text-center">
                            <img class="rounded-circle mb-3" src="<?php echo e($agentAvatarUrl); ?>"
                                onerror="this.onerror=null;this.src='<?php echo e($agentPlaceholder); ?>';"
                                alt="<?php echo e($usuario->name ?? 'Asesor inmobiliario'); ?>"
                                title="<?php echo e($usuario->name ?? 'Asesor inmobiliario'); ?>" loading="lazy"
                                style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #f0ad4e;">

                            <h3 class="h6 mb-1"><?php echo e($usuario->name ?? 'Asesor inmobiliario'); ?></h3>
                            <?php if($usuario->email ?? false): ?>
                                <p class="text-muted small mb-2">
                                    <a href="mailto:<?php echo e($usuario->email); ?>" class="text-decoration-none">
                                        <?php echo e($usuario->email); ?>

                                    </a>
                                </p>
                            <?php endif; ?>

                            <div class="d-grid gap-2">
                                <?php if($whatsAppUrl): ?>
                                    <a href="<?php echo e($whatsAppUrl); ?>" target="_blank" rel="noopener noreferrer"
                                        class="btn btn-success btn-sm">
                                        <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                    </a>
                                <?php endif; ?>
                                <?php if($usuario->telefono ?? false): ?>
                                    <a href="tel:<?php echo e($usuario->telefono); ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-phone me-1"></i> Llamar
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </aside>

                    <!-- Property Summary Card -->
                    <aside class="summary-card card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h3 class="card-title h6 mb-3">Información rápida</h3>
                            <dl class="row mb-0 small">
                                <dt class="col-7 text-muted">Estado:</dt>
                                <dd class="col-5 text-end"><strong><?php echo e($propiedad->estado); ?></strong></dd>

                                <dt class="col-7 text-muted">Tipo:</dt>
                                <dd class="col-5 text-end"><strong><?php echo e($propiedad->tipo); ?></strong></dd>

                                <dt class="col-7 text-muted">Zona:</dt>
                                <dd class="col-5 text-end"><strong><?php echo e($propiedad->zona); ?></strong></dd>

                                <dt class="col-7 text-muted">Año publicado:</dt>
                                <dd class="col-5 text-end"><strong>
                                        <?php if($propiedad->created_at): ?>
                                            <?php echo e(date('Y', strtotime($propiedad->created_at))); ?><?php else: ?>-
                                        <?php endif; ?>
                                    </strong></dd>
                            </dl>
                        </div>
                    </aside>

                    <!-- Share Card -->
                    <aside class="share-card card shadow-sm border-0">
                        <div class="card-body">
                            <h3 class="card-title h6 mb-3">Compartir propiedad</h3>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(url()->current())); ?>"
                                    target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary btn-sm"
                                    aria-label="Compartir en Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode(url()->current())); ?>&text=<?php echo e(urlencode($propiedad->titulo)); ?>"
                                    target="_blank" rel="noopener noreferrer" class="btn btn-outline-info btn-sm"
                                    aria-label="Compartir en Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo e(urlencode(url()->current())); ?>"
                                    target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary btn-sm"
                                    aria-label="Compartir en LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                    onclick="navigator.clipboard.writeText('<?php echo e(url()->current()); ?>'); alert('Link copiado')"
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
    <?php if(!$propiedades_relacionadas->isEmpty()): ?>
        <section class="related-properties py-5 bg-light">
            <div class="container-lg">
                <h2 class="h4 mb-4">Propiedades relacionadas</h2>
                <div class="row g-4">
                    <?php $__currentLoopData = $propiedades_relacionadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 col-lg-6">
                            <div class="card shadow-sm border-0 h-100 overflow-hidden transition-all"
                                style="transition: transform 0.3s ease;">
                                <a href="<?php echo e(route('propiedad', $prop->slug)); ?>" class="text-decoration-none text-dark">
                                    <div class="position-relative overflow-hidden" style="height: 200px;">
                                        <img loading="lazy"
                                            src="<?php echo e($resolvePropertyImage($prop->foto_portada, optional($prop)->updated_at, $propertyPlaceholder)); ?>"
                                            onerror="this.onerror=null;this.src='<?php echo e($propertyPlaceholder); ?>';"
                                            alt="<?php echo e($prop->titulo); ?>" class="w-100 h-100"
                                            style="object-fit: cover; transition: transform 0.3s ease;">
                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge bg-primary"><?php echo e($prop->estado); ?></span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <h3 class="card-title h6 mb-2"><?php echo e($prop->titulo); ?></h3>
                                        <p class="text-muted small mb-2">
                                            <i class="fas fa-map-marker-alt"></i> <?php echo e($prop->zona); ?>

                                        </p>
                                        <div class="row g-2 mb-3 small">
                                            <div class="col-6">
                                                <span class="text-muted"><i class="fas fa-door-open"></i>
                                                    <?php echo e($prop->habitaciones ?? '-'); ?></span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted"><i class="fas fa-bath"></i>
                                                    <?php echo e($prop->banos ?? '-'); ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="text-primary"><?php echo e($prop->Moneda); ?>

                                                <?php echo e(number_format($prop->precio ?? 0, 2)); ?></strong>
                                            <small
                                                class="text-muted"><?php echo e($prop->metraje ? $prop->metraje . ' m²' : '-'); ?></small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.layout-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/frontend/propiedad.blade.php ENDPATH**/ ?>