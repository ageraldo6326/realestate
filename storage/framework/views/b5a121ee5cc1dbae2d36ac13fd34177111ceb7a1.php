

<?php $__env->startSection('seo_title', ($inmo->titulo ?? 'Portal Inmobiliario') . ' — ' . ($inmo->slogan ?? 'Encuentra tu hogar ideal')); ?>
<?php $__env->startSection('seo_description',
    $inmo->metadescription ??
    'Encuentra las mejores propiedades en venta y alquiler. Tu nuevo
    hogar te espera.'); ?>

<?php $__env->startSection('content'); ?>

    <?php
        $portada = $portadas->first();
        $propertyPlaceholder = asset('assets/prop-apto-1.jpg');
        $personPlaceholder = 'https://dummyimage.com/160x160/edf2f7/6b7280&text=Asesor';
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
        $heroImgRaw = $portada && !empty($portada->foto) ? trim((string) $portada->foto) : '';
        if (
            $heroImgRaw !== '' &&
            \Illuminate\Support\Str::startsWith($heroImgRaw, ['http://', 'https://', '//', 'data:'])
        ) {
            $heroImg = $heroImgRaw;
        } elseif ($heroImgRaw !== '' && str_contains($heroImgRaw, '/')) {
            $heroImg = asset(ltrim($heroImgRaw, '/'));
        } elseif ($heroImgRaw !== '') {
            $heroImg = asset('assets/' . ltrim($heroImgRaw, '/'));
        } else {
            $heroImg = $propertyPlaceholder;
        }
        $heroTitle = $portada ? $portada->titulo : $inmo->titulo ?? 'Encuentra el hogar que siempre soñaste';
        $heroSub = $portada ? $portada->minititulo : 'TU NUEVO COMIENZO, ESTÁ AQUÍ';
        $heroDesc = $portada ? strip_tags($portada->descripcion) : 'Explora miles de propiedades en venta y alquiler.';
    ?>

    <!-- HERO SECTION -->
    <section class="hero-section" aria-label="Sección principal"
        <?php if($heroImg): ?> style="background-image:linear-gradient(to right,rgba(28,28,46,.78) 40%,rgba(28,28,46,.2) 100%),url('<?php echo e($heroImg); ?>');background-size:cover;background-position:center" <?php endif; ?>>
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
                    <!-- Búsqueda rápida: lleva al listado de propiedades -->
                    <div class="hero-search-box mt-4">
                        <div class="search-widget">
                            <form method="GET" action="<?php echo e(route('listapropiedades')); ?>" role="search">
                                <div class="row g-2 align-items-end">
                                    <div class="col-lg-3 col-md-6">
                                        <label class="form-label" for="hero-provincia">Provincia</label>
                                        <select name="provincia_id" id="hero-provincia" class="form-select">
                                            <option value="">Selecciona provincia</option>
                                            <?php $__currentLoopData = $provincias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provincia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($provincia->id); ?>"><?php echo e($provincia->provincia); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <label class="form-label" for="hero-sector">Sector</label>
                                        <select name="sector_id" id="hero-sector" class="form-select">
                                            <option value="">Selecciona sector</option>
                                            <?php $__currentLoopData = $sectores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sector): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($sector->id); ?>"
                                                    data-provincia="<?php echo e($sector->provincia_id); ?>"><?php echo e($sector->sector); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <label class="form-label" for="hero-tipo">Tipo de propiedad</label>
                                        <select name="tipo_id" id="hero-tipo" class="form-select">
                                            <option value="">Selecciona tipo</option>
                                            <?php $__currentLoopData = $tipos_propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->tipo); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6 d-grid">
                                        <button type="submit" class="btn-search">
                                            <i class="fas fa-magnifying-glass"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
                                        <img loading="lazy"
                                            src="<?php echo e($resolvePropertyImage($pro->foto_portada, optional($pro)->updated_at, $propertyPlaceholder)); ?>"
                                            onerror="this.onerror=null;this.src='<?php echo e($propertyPlaceholder); ?>';"
                                            alt="<?php echo e($pro->titulo); ?>" title="<?php echo e($pro->titulo); ?>">
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
                                        <img src="<?php echo e($asesorFoto); ?>" alt="<?php echo e($asesorNombre); ?>" loading="lazy"
                                            onerror="this.onerror=null;this.src='<?php echo e($personPlaceholder); ?>';"
                                            style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover;"
                                            class="mr-2">
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
} elseif ($_instance->childHasBeenRendered('3ZOTdrH')) {
    $componentId = $_instance->getRenderedChildComponentId('3ZOTdrH');
    $componentTag = $_instance->getRenderedChildComponentTagName('3ZOTdrH');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('3ZOTdrH');
} else {
    $response = \Livewire\Livewire::mount('buscar-propiedades-home');
    $html = $response->html();
    $_instance->logRenderedChild('3ZOTdrH', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
                                        <img loading="lazy"
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
                                            href="<?php echo e(route('post.show', $post->slug)); ?>"><?php echo $post->titulo; ?></a></h3>
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

    <!-- HOME PAGE STYLES -->
    <style>
        .hero-section {
            min-height: 88vh;
            display: flex;
            align-items: center;
            background-color: var(--clr-dark);
            background-size: cover;
            background-position: center
        }

        .hero-container {
            padding-top: 4rem;
            padding-bottom: 4rem
        }

        .hero-content {
            color: var(--clr-white)
        }

        .hero-eyebrow {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--clr-accent);
            margin-bottom: 1rem
        }

        .hero-title {
            font-family: var(--ff-head);
            font-size: clamp(2rem, 5vw, 3.8rem);
            font-weight: 700;
            line-height: 1.15;
            color: var(--clr-white);
            margin-bottom: 1rem
        }

        .hero-desc {
            font-size: 1rem;
            line-height: 1.7;
            color: rgba(255, 255, 255, .8);
            margin-bottom: 0;
            max-width: 460px
        }

        .hero-search-box .search-widget {
            max-width: 560px
        }

        .benefits-section {
            padding: 2.5rem 0;
            background: var(--clr-white);
            border-bottom: 1px solid var(--clr-border)
        }

        .benefit-card {
            display: flex;
            align-items: flex-start;
            gap: .9rem;
            padding: 1rem .75rem;
            border-radius: var(--radius);
            transition: var(--transition)
        }

        .benefit-card:hover {
            background: var(--clr-bg)
        }

        .benefit-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(201, 168, 76, .12);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0
        }

        .benefit-icon i {
            font-size: 1.2rem;
            color: var(--clr-accent)
        }

        .benefit-title {
            font-size: .9rem;
            font-weight: 700;
            color: var(--clr-dark);
            margin-bottom: .3rem;
            line-height: 1.3
        }

        .benefit-desc {
            font-size: .78rem;
            color: var(--clr-gray);
            margin: 0;
            line-height: 1.5
        }

        .featured-section {
            padding: 5rem 0;
            background: var(--clr-white)
        }

        .whatsapp-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background: #25D366;
            color: #fff;
            border-radius: 50%;
            font-size: .85rem;
            text-decoration: none;
            transition: var(--transition)
        }

        .whatsapp-btn:hover {
            background: #1da851;
            color: #fff
        }

        .search-results-section {
            padding: 5rem 0
        }

        .how-section {
            padding: 5rem 0;
            background: var(--clr-white)
        }

        .how-card {
            text-align: center;
            padding: 2rem 1.25rem;
            border-radius: var(--radius);
            border: 1px solid var(--clr-border);
            background: var(--clr-white);
            position: relative;
            transition: var(--transition);
            display: flex;
            flex-direction: column
        }

        .how-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
            border-color: var(--clr-accent-lt)
        }

        .how-number {
            position: absolute;
            top: -1rem;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--clr-accent);
            color: var(--clr-dark);
            font-size: .78rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .how-icon {
            margin: .75rem auto .6rem
        }

        .how-icon img {
            width: 60px;
            height: 60px;
            object-fit: contain
        }

        .how-title {
            font-size: .95rem;
            font-weight: 700;
            color: var(--clr-dark);
            margin-bottom: .4rem
        }

        .how-desc {
            font-size: .8rem;
            color: var(--clr-gray);
            line-height: 1.6;
            margin: 0;
            flex: 1
        }

        .blog-section {
            padding: 5rem 0
        }

        .blog-card {
            border-radius: var(--radius);
            overflow: hidden;
            background: var(--clr-white);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--clr-border);
            transition: var(--transition);
            height: 100%;
            display: flex;
            flex-direction: column
        }

        .blog-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-3px)
        }

        .blog-card-img-wrap {
            display: block;
            height: 200px;
            overflow: hidden
        }

        .blog-card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s
        }

        .blog-card:hover .blog-card-img-wrap img {
            transform: scale(1.05)
        }

        .blog-card-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex: 1
        }

        .blog-meta {
            display: flex;
            gap: 1rem;
            font-size: .72rem;
            color: var(--clr-gray-lt);
            margin-bottom: .7rem
        }

        .blog-meta span {
            display: flex;
            align-items: center;
            gap: .3rem
        }

        .blog-title {
            font-size: .95rem;
            font-weight: 600;
            line-height: 1.4;
            flex: 1;
            margin-bottom: 1rem
        }

        .blog-title a {
            color: var(--clr-dark);
            text-decoration: none;
            transition: color .2s
        }

        .blog-title a:hover {
            color: var(--clr-accent)
        }

        .blog-read-more {
            color: var(--clr-accent);
            font-weight: 600;
            font-size: .82rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: gap .2s
        }

        .blog-read-more:hover {
            gap: .7rem;
            color: var(--clr-accent)
        }

        .testimonials-section {
            padding: 5rem 0;
            background: var(--clr-bg)
        }

        .testimonial-card {
            background: var(--clr-white);
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--clr-border);
            transition: var(--transition);
            height: 100%;
            display: flex;
            flex-direction: column
        }

        .testimonial-card:hover {
            box-shadow: var(--shadow-md)
        }

        .testimonial-quote {
            color: var(--clr-accent);
            font-size: 1.4rem;
            margin-bottom: 1rem;
            display: block;
            opacity: .6
        }

        .testimonial-text {
            font-size: .88rem;
            color: var(--clr-gray);
            line-height: 1.7;
            margin-bottom: 1.25rem;
            flex: 1
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: .75rem;
            border-top: 1px solid var(--clr-border);
            padding-top: .9rem
        }

        .testimonial-author img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--clr-accent-lt)
        }

        .testimonial-name {
            font-size: .88rem;
            color: var(--clr-dark);
            font-weight: 600
        }

        @media(max-width:575px) {
            .hero-section {
                min-height: auto;
                padding-top: 3rem;
                padding-bottom: 2rem
            }

            .hero-title {
                font-size: 2rem
            }
        }
    </style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra_scripts'); ?>
    <script>
        (function() {
            var provSel = document.getElementById('hero-provincia');
            var sectorSel = document.getElementById('hero-sector');
            if (!provSel || !sectorSel) return;

            var allOptions = Array.from(sectorSel.options);

            function filterSectores() {
                var val = provSel.value;
                sectorSel.innerHTML = '';
                var first = new Option('Selecciona sector', '');
                sectorSel.appendChild(first);
                allOptions.forEach(function(opt) {
                    if (opt.value === '') return;
                    if (!val || opt.dataset.provincia === val) {
                        sectorSel.appendChild(opt.cloneNode(true));
                    }
                });
                sectorSel.value = '';
            }

            provSel.addEventListener('change', filterSectores);

            if (provSel.value) filterSectores();
        })();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.layout-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/frontend/home.blade.php ENDPATH**/ ?>