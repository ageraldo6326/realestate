<?php $__env->startSection('seo_title', ($inmo->titulo ?? 'Portal Inmobiliario') . ' — ' . ($inmo->slogan ?? 'Encuentra tu hogar ideal')); ?>
<?php $__env->startSection('seo_description',
    $inmo->metadescription ??
    'Encuentra las mejores propiedades en venta y alquiler. Tu nuevo
    hogar te espera.'); ?>

<?php $__env->startSection('defer_bootstrap', 'true'); ?>

<?php
    $firstPortada = $portadas->first();
    $heroPreloadRaw = trim((string) optional($firstPortada)->foto);

    if ($heroPreloadRaw !== '' && \Illuminate\Support\Str::startsWith($heroPreloadRaw, ['http://', 'https://', '//', 'data:'])) {
        $heroPreloadUrl = $heroPreloadRaw;
    } elseif ($heroPreloadRaw !== '' && str_contains($heroPreloadRaw, '/')) {
        $heroPreloadUrl = asset(ltrim($heroPreloadRaw, '/'));
    } elseif ($heroPreloadRaw !== '') {
        $heroPreloadUrl = asset('assets/' . ltrim($heroPreloadRaw, '/'));
    } else {
        $heroPreloadUrl = null;
    }

    $isBundledHero = basename((string) parse_url((string) $heroPreloadUrl, PHP_URL_PATH)) === 'portada-hero.jpg';
    $heroMobileUrl = $isBundledHero ? asset('assets/portada-hero-640.webp') : null;
    $heroDesktopUrl = $isBundledHero ? asset('assets/portada-hero-1280.webp') : null;
?>

<?php $__env->startSection('extra_styles'); ?>
    <?php if($heroMobileUrl && $heroDesktopUrl): ?>
        <link rel="preload" as="image" href="<?php echo e($heroMobileUrl); ?>" type="image/webp" media="(max-width: 767px)"
            fetchpriority="high">
        <link rel="preload" as="image" href="<?php echo e($heroDesktopUrl); ?>" type="image/webp" media="(min-width: 768px)"
            fetchpriority="high">
    <?php elseif($heroPreloadUrl): ?>
        <link rel="preload" as="image" href="<?php echo e($heroPreloadUrl); ?>" fetchpriority="high">
    <?php endif; ?>

    <style>
        /* Base mínimo para renderizar encabezado y hero antes del CSS diferido. */
        *, *::before, *::after { box-sizing: border-box; }
        .container { width: 100%; margin: 0 auto; padding-right: .75rem; padding-left: .75rem; }
        .row { display: flex; flex-wrap: wrap; margin-right: -.75rem; margin-left: -.75rem; }
        .row > * { width: 100%; max-width: 100%; padding-right: .75rem; padding-left: .75rem; }
        .navbar { position: relative; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; }
        .navbar > .container { display: flex; flex-wrap: inherit; align-items: center; justify-content: space-between; }
        .navbar-brand { display: inline-flex; align-items: center; }
        .navbar-toggler { display: block; padding: .25rem .75rem; border: 1px solid transparent; border-radius: .375rem; background: transparent; }
        .navbar-toggler-icon { display: block; width: 1.5em; height: 1.5em; background: linear-gradient(var(--clr-dark), var(--clr-dark)) center top / 100% 2px no-repeat, linear-gradient(var(--clr-dark), var(--clr-dark)) center / 100% 2px no-repeat, linear-gradient(var(--clr-dark), var(--clr-dark)) center bottom / 100% 2px no-repeat; }
        .navbar-collapse { display: none; flex-basis: 100%; flex-grow: 1; }
        .navbar-collapse.show { display: block; }
        .navbar-nav { display: flex; flex-direction: column; padding-left: 0; margin-bottom: 0; list-style: none; }
        .d-flex { display: flex !important; } .align-items-center { align-items: center !important; }
        .mx-auto { margin-right: auto !important; margin-left: auto !important; }
        .me-1 { margin-right: .25rem !important; } .gap-1 { gap: .25rem !important; } .gap-2 { gap: .5rem !important; }
        .hero-section { position: relative; isolation: isolate; min-height: 88vh; display: flex; align-items: center; overflow: hidden; background: var(--clr-dark); }
        .hero-media, .hero-media img { position: absolute; inset: 0; width: 100%; height: 100%; }
        .hero-media img { object-fit: cover; object-position: center; }
        .hero-section::before { position: absolute; z-index: 1; inset: 0; content: ''; background: linear-gradient(to right, rgba(28,28,46,.78) 40%, rgba(28,28,46,.2) 100%); }
        .hero-container { position: relative; z-index: 2; padding-top: 4rem; padding-bottom: 4rem; }
        .hero-content { color: var(--clr-white); }
        .hero-eyebrow { margin-bottom: 1rem; color: var(--clr-accent); font-size: .7rem; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; }
        .hero-title { margin-bottom: 1rem; color: var(--clr-white); font-family: var(--ff-head); font-size: clamp(2rem, 5vw, 3.8rem); font-weight: 700; line-height: 1.15; }
        .hero-desc { max-width: 460px; margin-bottom: 0; color: rgba(255, 255, 255, .8); font-size: 1rem; line-height: 1.7; }
        @media (min-width: 576px) { .container { max-width: 540px; } }
        @media (min-width: 768px) { .container { max-width: 720px; } }
        @media (min-width: 992px) { .container { max-width: 960px; } .navbar-expand-lg .navbar-toggler { display: none; } .navbar-expand-lg .navbar-collapse { display: flex !important; flex-basis: auto; } .navbar-expand-lg .navbar-nav { flex-direction: row; } .col-lg-8 { flex: 0 0 auto; width: 66.666667%; } }
        @media (min-width: 1200px) { .container { max-width: 1140px; } }
        @media (max-width: 575px) { .hero-section { min-height: auto; padding-top: 3rem; padding-bottom: 2rem; } .hero-title { font-size: 2rem; } }
    </style>

    <link rel="preload" as="style" href="<?php echo e(asset('css/home-non-critical.min.css')); ?>"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="<?php echo e(asset('css/home-non-critical.min.css')); ?>"></noscript>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php
        $portada = $firstPortada;
        $propertyPlaceholder = asset('assets/prop-apto-1.jpg');
        $personPlaceholder = 'https://dummyimage.com/160x160/edf2f7/6b7280&text=Asesor';
        $cardThumbnails = app(\App\Services\PropertyCardThumbnailService::class);
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
        $heroImg = $heroPreloadUrl ?: $propertyPlaceholder;
        $heroTitle = $portada ? $portada->titulo : $inmo->titulo ?? 'Encuentra el hogar que siempre soñaste';
        $heroSub = $portada ? $portada->minititulo : 'TU NUEVO COMIENZO, ESTÁ AQUÍ';
        $heroDesc = $portada ? strip_tags($portada->descripcion) : 'Explora miles de propiedades en venta y alquiler.';
    ?>

    <!-- HERO SECTION -->
    <section class="hero-section" aria-label="Sección principal">
        <picture class="hero-media" aria-hidden="true">
            <?php if($heroMobileUrl && $heroDesktopUrl): ?>
                <source media="(max-width: 767px)" srcset="<?php echo e($heroMobileUrl); ?>" type="image/webp">
                <source media="(min-width: 768px)" srcset="<?php echo e($heroDesktopUrl); ?>" type="image/webp">
            <?php endif; ?>
            <img src="<?php echo e($heroImg); ?>" alt="" width="1600" height="1031" fetchpriority="high" decoding="sync">
        </picture>
        <div class="container hero-container">
            <div class="row align-items-center">
                <div class="col-lg-8 hero-content">
                    <p class="hero-eyebrow"><?php echo e($heroSub); ?></p>
                    <?php
                        $words = explode(' ', $heroTitle);
                        $last = array_pop($words);
                        $rest = implode(' ', $words);
                    ?>
                    <h1 class="hero-title"><?php echo e($rest); ?> <span class="text-accent"><?php echo e($last); ?></span></h1>
                    <p class="hero-desc"><?php echo e($heroDesc); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- BENEFITS STRIP -->
    <section class="benefits-section" aria-label="Beneficios">
        <div class="container">
            <div class="row g-3">
                <div class="col-lg-3 col-sm-6">
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="fas fa-house-chimney"></i></div>
                        <div>
                            <h3 class="benefit-title">Miles de propiedades</h3>
                            <p class="benefit-desc">La mayor selección de propiedades verificadas en un solo lugar.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="fas fa-shield-halved"></i></div>
                        <div>
                            <h3 class="benefit-title">Compra segura</h3>
                            <p class="benefit-desc">Procesos seguros y transparentes para tu tranquilidad.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="fas fa-headset"></i></div>
                        <div>
                            <h3 class="benefit-title">Asesoría personalizada</h3>
                            <p class="benefit-desc">Expertos inmobiliarios para ayudarte en cada paso.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="fas fa-file-circle-plus"></i></div>
                        <div>
                            <h3 class="benefit-title">Publica gratis</h3>
                            <p class="benefit-desc">Publica tu propiedad gratis y llega a más compradores.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PROPIEDADES DESTACADAS -->
    <?php if($pro_destacadas->count()): ?>
        <section class="featured-section" aria-labelledby="featured-heading">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-badge">DESTACADOS</span>
                    <h2 class="section-title" id="featured-heading">Propiedades destacadas</h2>
                    <p class="section-subtitle">Descubre nuestras mejores propiedades seleccionadas para ti.</p>
                </div>
                <div class="row g-4">
                    <?php $__currentLoopData = $pro_destacadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 col-md-6">
                            <article class="prop-card h-100">
                                <div class="card-img-wrap">
                                    <a href="<?php echo e(route('propiedad', $pro->slug)); ?>" aria-label="<?php echo e($pro->titulo); ?>">
                                        <?php
                                            $propertyImage = $resolvePropertyImage($pro->foto_portada, optional($pro)->updated_at, $propertyPlaceholder);
                                            $propertyThumbnail = $cardThumbnails->urlFor($pro->foto_portada);
                                        ?>
                                        <picture>
                                            <?php if($propertyThumbnail): ?>
                                                <source type="image/webp" srcset="<?php echo e($propertyThumbnail); ?>"
                                                    sizes="(max-width: 767px) 100vw, (max-width: 1199px) 50vw, 33vw">
                                            <?php endif; ?>
                                            <img loading="lazy" width="640" height="480" decoding="async"
                                                src="<?php echo e($propertyImage); ?>"
                                                onerror="this.onerror=null;this.src='<?php echo e($propertyPlaceholder); ?>';"
                                                alt="<?php echo e($pro->titulo); ?>" title="<?php echo e($pro->titulo); ?>">
                                        </picture>
                                    </a>
                                    <?php $disp=strtolower($pro->disponible_para ?? ''); ?>
                                    <span
                                        class="badge-status <?php echo e(str_contains($disp, 'alquil') ? 'en-alquiler' : ''); ?>"><?php echo e($pro->disponible_para); ?></span>
                                    <span
                                        class="price-overlay"><?php echo e($pro->Moneda); ?><?php echo e(number_format($pro->precio, 0)); ?></span>
                                </div>
                                <div class="card-body">
                                    <?php
                                        $asesorNombre = $pro->asesor_nombre ?: 'Asesor inmobiliario';
                                        $asesorFotoRaw = $pro->asesor_foto ?: '';
                                        if (
                                            $asesorFotoRaw &&
                                            \Illuminate\Support\Str::startsWith($asesorFotoRaw, [
                                                'http://',
                                                'https://',
                                                '//',
                                                'data:',
                                            ])
                                        ) {
                                            $asesorFoto = $asesorFotoRaw;
                                        } elseif (
                                            $asesorFotoRaw &&
                                            \Illuminate\Support\Str::startsWith($asesorFotoRaw, [
                                                '/img/',
                                                '/assets/',
                                                'img/',
                                                'assets/',
                                            ])
                                        ) {
                                            $asesorFoto = asset(ltrim($asesorFotoRaw, '/'));
                                        } elseif ($asesorFotoRaw) {
                                            $asesorFoto = asset('assets/' . ltrim($asesorFotoRaw, '/'));
                                        } else {
                                            $asesorFoto = $personPlaceholder;
                                        }
                                    ?>
                                    <?php $asesorThumbnail = $cardThumbnails->urlFor($asesorFotoRaw, 96); ?>
                                    <h3 class="card-title mb-0">
                                        <a href="<?php echo e(route('propiedad', $pro->slug)); ?>"><?php echo e($pro->titulo); ?></a>
                                    </h3>
                                    <?php
                                        $ubicacion = trim(
                                            collect([
                                                $pro->barrio_nombre ?: null,
                                                $pro->sector_nombre ?: null,
                                                $pro->ciudad ?: null,
                                                $pro->provincia_nombre ?: null,
                                            ])
                                                ->filter()
                                                ->implode(', '),
                                        );
                                    ?>
                                    <div class="prop-location">
                                        <i class="fas fa-location-dot text-accent"></i>
                                        <span><?php echo e($ubicacion ?: 'Republica Dominicana'); ?></span>
                                    </div>
                                    <div class="prop-specs">
                                        <?php if($pro->habitaciones): ?>
                                            <div class="prop-spec"><i
                                                    class="fas fa-bed"></i><span><?php echo e($pro->habitaciones); ?></span></div>
                                        <?php endif; ?>
                                        <?php if($pro->banos): ?>
                                            <div class="prop-spec"><i
                                                    class="fas fa-bath"></i><span><?php echo e($pro->banos); ?></span></div>
                                        <?php endif; ?>
                                        <?php if($pro->parqueos): ?>
                                            <div class="prop-spec"><i
                                                    class="fas fa-car"></i><span><?php echo e($pro->parqueos); ?></span></div>
                                        <?php endif; ?>
                                        <?php if($pro->metraje): ?>
                                            <div class="prop-spec"><i
                                                    class="fas fa-vector-square"></i><span><?php echo e($pro->metraje); ?> m²</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="prop-ref">REF: <?php echo e($pro->referencia); ?></span>
                                        <?php if($pro->asesor_telefono): ?>
                                            <a href="<?php echo e('https://api.whatsapp.com/send/?phone=' . $pro->asesor_telefono . '&text=' . urlencode($pro->descripcion_corta . ' ' . route('propiedad', $pro->slug))); ?>"
                                                target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"
                                                class="whatsapp-btn">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex align-items-center mt-3 pt-2 border-top">
                                        <picture>
                                            <?php if($asesorThumbnail): ?>
                                                <source type="image/webp" srcset="<?php echo e($asesorThumbnail); ?>" sizes="34px">
                                            <?php endif; ?>
                                            <img src="<?php echo e($asesorFoto); ?>" alt="<?php echo e($asesorNombre); ?>" width="34" height="34" loading="lazy"
                                                onerror="this.onerror=null;this.src='<?php echo e($personPlaceholder); ?>';"
                                                style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover;"
                                                class="mr-2">
                                        </picture>
                                        <span class="small text-muted">Asesor: <?php echo e($asesorNombre); ?></span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="text-center mt-5">
                    <a href="<?php echo e(route('listapropiedades')); ?>" class="btn-primary-solid">Ver todas las propiedades <i
                            class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- BUSCA TU PROPIEDAD (Livewire: filtrado + paginación) -->
    <section class="search-results-section bg-light-custom" aria-labelledby="search-heading">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-badge">EXPLORAR</span>
                <h2 class="section-title" id="search-heading">Encuentra tu propiedad</h2>
                <p class="section-subtitle">Filtra y explora todas las propiedades disponibles.</p>
            </div>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('buscar-propiedades-home')->html();
} elseif ($_instance->childHasBeenRendered('KpNXod4')) {
    $componentId = $_instance->getRenderedChildComponentId('KpNXod4');
    $componentTag = $_instance->getRenderedChildComponentTagName('KpNXod4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('KpNXod4');
} else {
    $response = \Livewire\Livewire::mount('buscar-propiedades-home');
    $html = $response->html();
    $_instance->logRenderedChild('KpNXod4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
    </section>

    <!-- CÓMO FUNCIONA / ENFOQUES -->
    <?php if($enfoques->count()): ?>
        <section class="how-section" aria-labelledby="how-heading">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-badge">CÓMO FUNCIONA</span>
                    <h2 class="section-title" id="how-heading">Encontrar tu hogar ideal es fácil</h2>
                    <p class="section-subtitle">En pocos pasos, da el primer paso hacia tu nuevo hogar.</p>
                </div>
                <div class="row g-4 justify-content-center">
                    <?php $__currentLoopData = $enfoques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $enfoque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-3 col-sm-6 col-12 d-flex">
                            <div class="how-card h-100 w-100">
                                <div class="how-number"><?php echo e($i + 1); ?></div>
                                <?php if($enfoque->foto): ?>
                                    <div class="how-icon">
                                        <img loading="lazy"
                                            src="<?php echo e(!empty($enfoque->foto) ? asset('assets/' . $enfoque->foto) : $propertyPlaceholder); ?>"
                                            onerror="this.onerror=null;this.src='<?php echo e($propertyPlaceholder); ?>';"
                                            alt="<?php echo e($enfoque->titulo); ?>" width="64" height="64">
                                    </div>
                                <?php endif; ?>
                                <h3 class="how-title"><?php echo e($enfoque->titulo); ?></h3>
                                <p class="how-desc"><?php echo $enfoque->enfoque; ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- BLOG / NOVEDADES -->
    <?php if($posts->count()): ?>
        <section class="blog-section bg-light-custom" aria-labelledby="blog-heading">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-badge">NOVEDADES</span>
                    <h2 class="section-title" id="blog-heading">Últimas noticias</h2>
                    <p class="section-subtitle">Mantente informado con las tendencias del mercado inmobiliario.</p>
                </div>
                <div class="row g-4">
                    <?php $__currentLoopData = $posts->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 col-md-6">
                            <article class="blog-card">
                                <?php if($post->foto): ?>
                                    <a href="<?php echo e(route('post.show', $post->slug)); ?>" class="blog-card-img-wrap"
                                        aria-label="<?php echo e($post->titulo); ?>">
                                        <img loading="lazy" width="640" height="480" decoding="async"
                                            src="<?php echo e(!empty($post->foto) ? asset('assets/' . $post->foto) : $propertyPlaceholder); ?>"
                                            onerror="this.onerror=null;this.src='<?php echo e($propertyPlaceholder); ?>';"
                                            alt="<?php echo e($post->titulo); ?>" title="<?php echo e($post->titulo); ?>">
                                    </a>
                                <?php endif; ?>
                                <div class="blog-card-body">
                                    <div class="blog-meta">
                                        <span><i class="fas fa-user"></i> <?php echo e($post->autor); ?></span>
                                        <span><i class="far fa-calendar"></i>
                                            <?php echo e(\Carbon\Carbon::parse($post->created_at)->format('d M, Y')); ?></span>
                                    </div>
                                    <h3 class="blog-title"><a
                                            href="<?php echo e(route('post.show', $post->slug)); ?>"><?php echo e($post->titulo); ?></a></h3>
                                    <a href="<?php echo e(route('post.show', $post->slug)); ?>" class="blog-read-more">Leer más <i
                                            class="fas fa-arrow-right"></i></a>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- TESTIMONIOS -->
    <?php if($testimonios->count()): ?>
        <section class="testimonials-section" aria-labelledby="testimonials-heading">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-badge">TESTIMONIOS</span>
                    <h2 class="section-title" id="testimonials-heading">Lo que dicen nuestros clientes</h2>
                </div>
                <div class="row g-4 justify-content-center">
                    <?php $__currentLoopData = $testimonios->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 col-md-6 d-flex">
                            <div class="testimonial-card h-100 w-100">
                                <i class="fas fa-quote-left testimonial-quote"></i>
                                <p class="testimonial-text"><?php echo $testimonio->testimonio; ?></p>
                                <div class="testimonial-author mt-auto">
                                    <?php if($testimonio->cliente_foto): ?>
                                        <img loading="lazy"
                                            src="<?php echo e(!empty($testimonio->cliente_foto) ? asset('assets/' . $testimonio->cliente_foto) : $personPlaceholder); ?>"
                                            onerror="this.onerror=null;this.src='<?php echo e($personPlaceholder); ?>';"
                                            alt="<?php echo e($testimonio->cliente); ?>" width="48" height="48">
                                    <?php endif; ?>
                                    <strong class="testimonial-name"><?php echo e($testimonio->cliente); ?></strong>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.layout-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/frontend/home.blade.php ENDPATH**/ ?>