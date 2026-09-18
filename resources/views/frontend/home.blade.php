@extends('layout.layout-landing')

@section('seo_title', ($inmo->titulo ?? 'Portal Inmobiliario') . ' — ' . ($inmo->slogan ?? 'Encuentra tu hogar ideal'))
@section('seo_description',
    $inmo->metadescription ??
    'Encuentra las mejores propiedades en venta y alquiler. Tu nuevo
    hogar te espera.')

@php
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
@endphp

@section('extra_styles')
    @if ($heroMobileUrl && $heroDesktopUrl)
        <link rel="preload" as="image" href="{{ $heroMobileUrl }}" type="image/webp" media="(max-width: 767px)"
            fetchpriority="high">
        <link rel="preload" as="image" href="{{ $heroDesktopUrl }}" type="image/webp" media="(min-width: 768px)"
            fetchpriority="high">
    @elseif ($heroPreloadUrl)
        <link rel="preload" as="image" href="{{ $heroPreloadUrl }}" fetchpriority="high">
    @endif

    <style>
        /* Base mínimo para renderizar encabezado y hero antes del CSS diferido. */
        *, *::before, *::after { box-sizing: border-box; }
        .container { width: 100%; margin: 0 auto; padding-right: .75rem; padding-left: .75rem; }
        .row { display: flex; flex-wrap: wrap; margin-right: -.75rem; margin-left: -.75rem; }
        .row > * { width: 100%; max-width: 100%; padding-right: .75rem; padding-left: .75rem; }
        .navbar { position: relative; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; }
        .navbar > .container { display: flex; flex-wrap: inherit; align-items: center; justify-content: space-between; }
        .navbar-brand { display: inline-flex; align-items: center; }
        .navbar-toggler { display: block; }
        .navbar-collapse { display: none; flex-basis: 100%; flex-grow: 1; }
        .navbar-collapse.show { display: block; }
        .hero-section { position: relative; isolation: isolate; min-height: 88vh; display: flex; align-items: center; overflow: hidden; background: var(--clr-dark); }
        .hero-media, .hero-media img { position: absolute; inset: 0; width: 100%; height: 100%; }
        .hero-media img { object-fit: cover; object-position: center; }
        .hero-section::before { position: absolute; z-index: 1; inset: 0; content: ''; background: linear-gradient(to right, rgba(28,28,46,.78) 40%, rgba(28,28,46,.2) 100%); }
        .hero-container { position: relative; z-index: 2; padding-top: 4rem; padding-bottom: 4rem; }
        @media (min-width: 576px) { .container { max-width: 540px; } }
        @media (min-width: 768px) { .container { max-width: 720px; } }
        @media (min-width: 992px) { .container { max-width: 960px; } .navbar-expand-lg .navbar-toggler { display: none; } .navbar-expand-lg .navbar-collapse { display: flex !important; flex-basis: auto; } .col-lg-8 { flex: 0 0 auto; width: 66.666667%; } }
        @media (min-width: 1200px) { .container { max-width: 1140px; } }
        @media (max-width: 575px) { .hero-section { min-height: auto; padding-top: 3rem; padding-bottom: 2rem; } }
    </style>
@endsection

@section('content')

    @php
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
    @endphp

    <!-- HERO SECTION -->
    <section class="hero-section" aria-label="Sección principal">
        <picture class="hero-media" aria-hidden="true">
            @if ($heroMobileUrl && $heroDesktopUrl)
                <source media="(max-width: 767px)" srcset="{{ $heroMobileUrl }}" type="image/webp">
                <source media="(min-width: 768px)" srcset="{{ $heroDesktopUrl }}" type="image/webp">
            @endif
            <img src="{{ $heroImg }}" alt="" width="1600" height="1031" fetchpriority="high" decoding="async">
        </picture>
        <div class="container hero-container">
            <div class="row align-items-center">
                <div class="col-lg-8 hero-content">
                    <p class="hero-eyebrow">{{ $heroSub }}</p>
                    @php
                        $words = explode(' ', $heroTitle);
                        $last = array_pop($words);
                        $rest = implode(' ', $words);
                    @endphp
                    <h1 class="hero-title">{{ $rest }} <span class="text-accent">{{ $last }}</span></h1>
                    <p class="hero-desc">{{ $heroDesc }}</p>
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
    @if ($pro_destacadas->count())
        <section class="featured-section" aria-labelledby="featured-heading">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-badge">DESTACADOS</span>
                    <h2 class="section-title" id="featured-heading">Propiedades destacadas</h2>
                    <p class="section-subtitle">Descubre nuestras mejores propiedades seleccionadas para ti.</p>
                </div>
                <div class="row g-4">
                    @foreach ($pro_destacadas as $pro)
                        <div class="col-lg-4 col-md-6">
                            <article class="prop-card h-100">
                                <div class="card-img-wrap">
                                    <a href="{{ route('propiedad', $pro->slug) }}" aria-label="{{ $pro->titulo }}">
                                        @php
                                            $propertyImage = $resolvePropertyImage($pro->foto_portada, optional($pro)->updated_at, $propertyPlaceholder);
                                            $propertyThumbnail = $cardThumbnails->urlFor($pro->foto_portada);
                                        @endphp
                                        <picture>
                                            @if ($propertyThumbnail)
                                                <source type="image/webp" srcset="{{ $propertyThumbnail }}"
                                                    sizes="(max-width: 767px) 100vw, (max-width: 1199px) 50vw, 33vw">
                                            @endif
                                            <img loading="lazy" width="640" height="480" decoding="async"
                                                src="{{ $propertyImage }}"
                                                onerror="this.onerror=null;this.src='{{ $propertyPlaceholder }}';"
                                                alt="{{ $pro->titulo }}" title="{{ $pro->titulo }}">
                                        </picture>
                                    </a>
                                    @php $disp=strtolower($pro->disponible_para ?? ''); @endphp
                                    <span
                                        class="badge-status {{ str_contains($disp, 'alquil') ? 'en-alquiler' : '' }}">{{ $pro->disponible_para }}</span>
                                    <span
                                        class="price-overlay">{{ $pro->Moneda }}{{ number_format($pro->precio, 0) }}</span>
                                </div>
                                <div class="card-body">
                                    @php
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
                                    @endphp
                                    @php $asesorThumbnail = $cardThumbnails->urlFor($asesorFotoRaw, 96); @endphp
                                    <h3 class="card-title mb-0">
                                        <a href="{{ route('propiedad', $pro->slug) }}">{{ $pro->titulo }}</a>
                                    </h3>
                                    @php
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
                                    @endphp
                                    <div class="prop-location">
                                        <i class="fas fa-location-dot text-accent"></i>
                                        <span>{{ $ubicacion ?: 'Republica Dominicana' }}</span>
                                    </div>
                                    <div class="prop-specs">
                                        @if ($pro->habitaciones)
                                            <div class="prop-spec"><i
                                                    class="fas fa-bed"></i><span>{{ $pro->habitaciones }}</span></div>
                                        @endif
                                        @if ($pro->banos)
                                            <div class="prop-spec"><i
                                                    class="fas fa-bath"></i><span>{{ $pro->banos }}</span></div>
                                        @endif
                                        @if ($pro->parqueos)
                                            <div class="prop-spec"><i
                                                    class="fas fa-car"></i><span>{{ $pro->parqueos }}</span></div>
                                        @endif
                                        @if ($pro->metraje)
                                            <div class="prop-spec"><i
                                                    class="fas fa-vector-square"></i><span>{{ $pro->metraje }} m²</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="prop-ref">REF: {{ $pro->referencia }}</span>
                                        @if ($pro->asesor_telefono)
                                            <a href="{{ 'https://api.whatsapp.com/send/?phone=' . $pro->asesor_telefono . '&text=' . urlencode($pro->descripcion_corta . ' ' . route('propiedad', $pro->slug)) }}"
                                                target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"
                                                class="whatsapp-btn">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center mt-3 pt-2 border-top">
                                        <picture>
                                            @if ($asesorThumbnail)
                                                <source type="image/webp" srcset="{{ $asesorThumbnail }}" sizes="34px">
                                            @endif
                                            <img src="{{ $asesorFoto }}" alt="{{ $asesorNombre }}" width="34" height="34" loading="lazy"
                                                onerror="this.onerror=null;this.src='{{ $personPlaceholder }}';"
                                                style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover;"
                                                class="mr-2">
                                        </picture>
                                        <span class="small text-muted">Asesor: {{ $asesorNombre }}</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('listapropiedades') }}" class="btn-primary-solid">Ver todas las propiedades <i
                            class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </section>
    @endif

    <!-- BUSCA TU PROPIEDAD (Livewire: filtrado + paginación) -->
    <section class="search-results-section bg-light-custom" aria-labelledby="search-heading">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-badge">EXPLORAR</span>
                <h2 class="section-title" id="search-heading">Encuentra tu propiedad</h2>
                <p class="section-subtitle">Filtra y explora todas las propiedades disponibles.</p>
            </div>
            @livewire('buscar-propiedades-home')
        </div>
    </section>

    <!-- CÓMO FUNCIONA / ENFOQUES -->
    @if ($enfoques->count())
        <section class="how-section" aria-labelledby="how-heading">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-badge">CÓMO FUNCIONA</span>
                    <h2 class="section-title" id="how-heading">Encontrar tu hogar ideal es fácil</h2>
                    <p class="section-subtitle">En pocos pasos, da el primer paso hacia tu nuevo hogar.</p>
                </div>
                <div class="row g-4 justify-content-center">
                    @foreach ($enfoques as $i => $enfoque)
                        <div class="col-lg-3 col-sm-6 col-12 d-flex">
                            <div class="how-card h-100 w-100">
                                <div class="how-number">{{ $i + 1 }}</div>
                                @if ($enfoque->foto)
                                    <div class="how-icon">
                                        <img loading="lazy"
                                            src="{{ !empty($enfoque->foto) ? asset('assets/' . $enfoque->foto) : $propertyPlaceholder }}"
                                            onerror="this.onerror=null;this.src='{{ $propertyPlaceholder }}';"
                                            alt="{{ $enfoque->titulo }}" width="64" height="64">
                                    </div>
                                @endif
                                <h3 class="how-title">{{ $enfoque->titulo }}</h3>
                                <p class="how-desc">{!! $enfoque->enfoque !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- BLOG / NOVEDADES -->
    @if ($posts->count())
        <section class="blog-section bg-light-custom" aria-labelledby="blog-heading">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-badge">NOVEDADES</span>
                    <h2 class="section-title" id="blog-heading">Últimas noticias</h2>
                    <p class="section-subtitle">Mantente informado con las tendencias del mercado inmobiliario.</p>
                </div>
                <div class="row g-4">
                    @foreach ($posts->take(3) as $post)
                        <div class="col-lg-4 col-md-6">
                            <article class="blog-card">
                                @if ($post->foto)
                                    <a href="{{ route('post.show', $post->slug) }}" class="blog-card-img-wrap"
                                        aria-label="{{ $post->titulo }}">
                                        <img loading="lazy" width="640" height="480" decoding="async"
                                            src="{{ !empty($post->foto) ? asset('assets/' . $post->foto) : $propertyPlaceholder }}"
                                            onerror="this.onerror=null;this.src='{{ $propertyPlaceholder }}';"
                                            alt="{{ $post->titulo }}" title="{{ $post->titulo }}">
                                    </a>
                                @endif
                                <div class="blog-card-body">
                                    <div class="blog-meta">
                                        <span><i class="fas fa-user"></i> {{ $post->autor }}</span>
                                        <span><i class="far fa-calendar"></i>
                                            {{ \Carbon\Carbon::parse($post->created_at)->format('d M, Y') }}</span>
                                    </div>
                                    <h3 class="blog-title"><a
                                            href="{{ route('post.show', $post->slug) }}">{{ $post->titulo }}</a></h3>
                                    <a href="{{ route('post.show', $post->slug) }}" class="blog-read-more">Leer más <i
                                            class="fas fa-arrow-right"></i></a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- TESTIMONIOS -->
    @if ($testimonios->count())
        <section class="testimonials-section" aria-labelledby="testimonials-heading">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-badge">TESTIMONIOS</span>
                    <h2 class="section-title" id="testimonials-heading">Lo que dicen nuestros clientes</h2>
                </div>
                <div class="row g-4 justify-content-center">
                    @foreach ($testimonios->take(3) as $testimonio)
                        <div class="col-lg-4 col-md-6 d-flex">
                            <div class="testimonial-card h-100 w-100">
                                <i class="fas fa-quote-left testimonial-quote"></i>
                                <p class="testimonial-text">{!! $testimonio->testimonio !!}</p>
                                <div class="testimonial-author mt-auto">
                                    @if ($testimonio->cliente_foto)
                                        <img loading="lazy"
                                            src="{{ !empty($testimonio->cliente_foto) ? asset('assets/' . $testimonio->cliente_foto) : $personPlaceholder }}"
                                            onerror="this.onerror=null;this.src='{{ $personPlaceholder }}';"
                                            alt="{{ $testimonio->cliente }}" width="48" height="48">
                                    @endif
                                    <strong class="testimonial-name">{{ $testimonio->cliente }}</strong>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

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

@endsection
