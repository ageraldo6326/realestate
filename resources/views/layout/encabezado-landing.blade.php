<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('seo_title', $inmo->titulo ?? 'Portal Inmobiliario')</title>
    <meta name="description" content="@yield('seo_description', $inmo->metadescription ?? '')">
    <meta name="keywords" content="{{ $inmo->palabrasclaves ?? '' }}">
    <link rel="canonical" href="{{ preg_replace('/^http:/i', 'https:', url()->current()) }}" />

    @if (isset($inmo) && $inmo->favicon)
        <link rel="shortcut icon" href="{{ asset('assets/' . $inmo->favicon) }}" type="image/x-icon" />
    @endif

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('seo_title', $inmo->titulo ?? 'Portal Inmobiliario')">
    <meta property="og:description" content="@yield('seo_description', $inmo->metadescription ?? '')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Playfair Display + Inter -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @livewireStyles

    <style>
        /* ===========================
           TOKENS DE DISEÑO
        =========================== */
        :root {
            --clr-accent: #C9A84C;
            --clr-accent-lt: #E8D49E;
            --clr-dark: #1C1C2E;
            --clr-dark-2: #2D2D3F;
            --clr-gray: #6B7280;
            --clr-gray-lt: #9CA3AF;
            --clr-bg: #F9F8F6;
            --clr-white: #FFFFFF;
            --clr-border: #E5E7EB;
            --ff-head: 'Playfair Display', Georgia, serif;
            --ff-body: 'Inter', system-ui, sans-serif;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, .06);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, .10);
            --shadow-lg: 0 8px 40px rgba(0, 0, 0, .14);
            --radius: 12px;
            --radius-sm: 8px;
            --transition: all .25s ease;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--ff-body);
            color: var(--clr-dark);
            background: var(--clr-white);
            -webkit-font-smoothing: antialiased;
        }

        img {
            max-width: 100%;
        }

        /* ===========================
           NAVBAR
        =========================== */
        .navbar-landing {
            background: var(--clr-white);
            box-shadow: var(--shadow-sm);
            padding: .85rem 0;
            position: sticky;
            top: 0;
            z-index: 1050;
            transition: var(--transition);
        }

        .navbar-landing .navbar-brand img {
            height: 48px;
            object-fit: contain;
        }

        .navbar-landing .navbar-brand .brand-text {
            font-family: var(--ff-head);
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--clr-dark);
            letter-spacing: -0.5px;
        }

        .navbar-landing .nav-link {
            color: var(--clr-dark) !important;
            font-size: .875rem;
            font-weight: 500;
            padding: .45rem 1rem !important;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            white-space: nowrap;
        }

        .navbar-landing .nav-link:hover {
            color: var(--clr-accent) !important;
            background: rgba(201, 168, 76, .08);
        }

        .navbar-landing .nav-link.active {
            color: var(--clr-accent) !important;
        }

        /* Especificidad elevada para superar .navbar-landing .nav-link */
        .navbar-landing .btn-nav-publish,
        .navbar-landing a.btn-nav-publish {
            background: var(--clr-dark);
            color: var(--clr-white) !important;
            font-size: .8rem !important;
            font-weight: 600 !important;
            padding: .55rem 1.25rem !important;
            border-radius: var(--radius-sm) !important;
            border: 2px solid transparent;
            transition: var(--transition);
        }

        .navbar-landing .btn-nav-publish:hover,
        .navbar-landing a.btn-nav-publish:hover {
            background: var(--clr-accent) !important;
            color: var(--clr-dark) !important;
        }

        .btn-nav-login {
            color: var(--clr-gray) !important;
            font-size: .875rem !important;
            font-weight: 500 !important;
            padding: .45rem .9rem !important;
            transition: var(--transition);
        }

        .btn-nav-login:hover {
            color: var(--clr-accent) !important;
        }

        .navbar-toggler {
            border: none !important;
            padding: .4rem .6rem;
        }

        .navbar-toggler:focus {
            box-shadow: none !important;
        }

        /* ===========================
           SECCIONES COMUNES
        =========================== */
        .section-badge {
            display: inline-block;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--clr-accent);
            margin-bottom: .75rem;
        }

        .section-title {
            font-family: var(--ff-head);
            font-size: clamp(1.8rem, 4vw, 2.6rem);
            font-weight: 700;
            color: var(--clr-dark);
            line-height: 1.2;
            margin-bottom: .75rem;
        }

        .section-subtitle {
            color: var(--clr-gray);
            font-size: 1rem;
            max-width: 520px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* ===========================
           PROPERTY CARDS
        =========================== */
        .prop-card {
            background: var(--clr-white);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: 1px solid var(--clr-border);
        }

        .prop-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }

        .prop-card .card-img-wrap {
            position: relative;
            overflow: hidden;
            height: 220px;
        }

        .prop-card .card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s ease;
        }

        .prop-card:hover .card-img-wrap img {
            transform: scale(1.05);
        }

        .prop-card .badge-status {
            position: absolute;
            top: .75rem;
            left: .75rem;
            background: var(--clr-dark);
            color: var(--clr-white);
            font-size: .7rem;
            font-weight: 600;
            padding: .3rem .7rem;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .prop-card .badge-status.en-alquiler {
            background: var(--clr-accent);
            color: var(--clr-dark);
        }

        .prop-card .price-overlay {
            position: absolute;
            bottom: .75rem;
            left: .75rem;
            background: rgba(28, 28, 46, .85);
            color: var(--clr-white);
            font-size: .95rem;
            font-weight: 700;
            padding: .3rem .8rem;
            border-radius: 6px;
            backdrop-filter: blur(4px);
        }

        .prop-card .card-body {
            padding: 1rem 1.2rem 1.2rem;
        }

        .prop-card .card-title a {
            color: var(--clr-dark);
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
            transition: color .2s;
        }

        .prop-card .card-title a:hover {
            color: var(--clr-accent);
        }

        .prop-card .prop-location {
            color: var(--clr-gray);
            font-size: .8rem;
            display: flex;
            align-items: center;
            gap: .35rem;
            margin: .4rem 0 .8rem;
        }

        .prop-card .prop-specs {
            display: flex;
            gap: 1rem;
            border-top: 1px solid var(--clr-border);
            padding-top: .75rem;
            margin-top: .5rem;
        }

        .prop-card .prop-spec {
            display: flex;
            align-items: center;
            gap: .3rem;
            font-size: .78rem;
            color: var(--clr-gray);
        }

        .prop-card .prop-spec i {
            color: var(--clr-accent);
            font-size: .75rem;
        }

        .prop-card .prop-ref {
            font-size: .72rem;
            color: var(--clr-gray-lt);
            margin-top: .6rem;
        }

        /* ===========================
           BOTONES GLOBALES
        =========================== */
        .btn-accent {
            background: var(--clr-accent);
            color: var(--clr-dark);
            font-weight: 600;
            font-size: .9rem;
            padding: .75rem 2rem;
            border-radius: var(--radius-sm);
            border: none;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }

        .btn-accent:hover {
            background: #b8943e;
            color: var(--clr-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(201, 168, 76, .4);
        }

        .btn-dark-outline {
            background: transparent;
            color: var(--clr-white);
            font-weight: 600;
            font-size: .9rem;
            padding: .75rem 2rem;
            border-radius: var(--radius-sm);
            border: 2px solid rgba(255, 255, 255, .6);
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }

        .btn-dark-outline:hover {
            border-color: var(--clr-white);
            background: rgba(255, 255, 255, .1);
            color: var(--clr-white);
        }

        .btn-primary-solid {
            background: var(--clr-dark);
            color: var(--clr-white);
            font-weight: 600;
            font-size: .9rem;
            padding: .75rem 2rem;
            border-radius: var(--radius-sm);
            border: none;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }

        .btn-primary-solid:hover {
            background: var(--clr-accent);
            color: var(--clr-dark);
        }

        /* ===========================
           SEARCH FORM (landing)
        =========================== */
        .search-widget {
            background: var(--clr-white);
            border-radius: var(--radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-lg);
        }

        .search-widget .form-label {
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .5px;
            text-transform: uppercase;
            color: var(--clr-gray);
            margin-bottom: .35rem;
        }

        .search-widget .form-select,
        .search-widget .form-control {
            border: 1.5px solid var(--clr-border);
            border-radius: var(--radius-sm);
            font-size: .875rem;
            padding: .65rem .9rem;
            color: var(--clr-dark);
            transition: border-color .2s;
        }

        .search-widget .form-select {
            /* Reserva espacio para el icono del dropdown y evita que el texto se monte sobre la flecha */
            padding-right: 2.4rem;
        }

        .search-widget .form-select:focus,
        .search-widget .form-control:focus {
            border-color: var(--clr-accent);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, .15);
            outline: none;
        }

        .search-widget .btn-search {
            background: var(--clr-dark);
            color: var(--clr-white);
            border: none;
            border-radius: var(--radius-sm);
            padding: .65rem 1.5rem;
            font-weight: 600;
            font-size: .875rem;
            transition: var(--transition);
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            cursor: pointer;
        }

        .search-widget .btn-search:hover {
            background: var(--clr-accent);
            color: var(--clr-dark);
        }

        /* ===========================
           UTILITIES
        =========================== */
        .text-accent {
            color: var(--clr-accent) !important;
        }

        .bg-light-custom {
            background: var(--clr-bg) !important;
        }

        @media (max-width: 991px) {
            .navbar-landing .navbar-nav {
                padding: 1rem 0;
                gap: .25rem;
            }

            .navbar-landing .d-flex.align-items-center {
                padding: .75rem 0 .5rem;
                gap: .5rem;
            }
        }
    </style>

    @yield('extra_styles')
</head>

<body>

    <!-- ===================== NAVBAR ===================== -->
    <nav class="navbar navbar-expand-lg navbar-landing" aria-label="Navegación principal">
        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('home') }}" aria-label="Inicio">
                @if (isset($inmo) && $inmo->logo)
                    <img src="{{ asset('assets/' . $inmo->logo) }}" alt="{{ $inmo->titulo ?? 'Logo' }}" height="48"
                        loading="eager">
                @else
                    <span class="brand-text">{{ $inmo->titulo ?? 'Inmobiliaria' }}</span>
                @endif
            </a>

            <!-- Mobile toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navLanding"
                aria-controls="navLanding" aria-expanded="false" aria-label="Abrir menú">
                <i class="fas fa-bars" style="font-size:1.2rem; color:var(--clr-dark)"></i>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="navLanding">
                <ul class="navbar-nav mx-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('listapropiedades') ? 'active' : '' }}"
                            href="{{ route('listapropiedades') }}">Propiedades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('equipo') ? 'active' : '' }}"
                            href="{{ route('equipo') }}">Agentes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('quienessomos') ? 'active' : '' }}"
                            href="{{ route('quienessomos') }}">Quiénes Somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('blog') ? 'active' : '' }}"
                            href="{{ route('blog') }}">Novedades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contactos') ? 'active' : '' }}"
                            href="{{ route('contactos') }}">Contacto</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('login') }}" class="nav-link btn-nav-login">
                        <i class="fa-regular fa-user me-1"></i> Ingresar
                    </a>
                    <a href="{{ route('contactos') }}" class="nav-link btn-nav-publish">
                        Publica tu propiedad
                    </a>
                </div>
            </div>

        </div>
    </nav>
    <!-- FIN NAVBAR -->
