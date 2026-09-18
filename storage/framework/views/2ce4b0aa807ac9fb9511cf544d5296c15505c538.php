<!DOCTYPE html>
<html lang="es">

<?php
    $resolvePublicAssetUrl = static function (?string $path): ?string {
        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if (
            \Illuminate\Support\Str::startsWith($path, [
                '/img/',
                'img/',
                '/assets/',
                'assets/',
                '/storage/',
                'storage/',
            ])
        ) {
            return url('/' . ltrim($path, '/'));
        }

        return asset('assets/' . ltrim($path, '/'));
    };

    $companyTitle = optional($inmo)->titulo ?: 'Portal Inmobiliario';
    $companyDescription = optional($inmo)->metadescription ?: '';
    $companyKeywords = optional($inmo)->palabrasclaves ?: '';
    $companyFaviconUrl = $resolvePublicAssetUrl(optional($inmo)->favicon);
    // El logo del portal es un recurso local, versionado y optimizado. Evita descargar
    // el PNG de 1.5 MB que estaba configurado previamente para una imagen de 48 px.
    $companyLogoUrl = asset('img/brand/logo-home-192.webp');
    $companyLogoPlaceholder = asset('assets/inmobiliaria/logo.png');
    $themeVariables =
        $frontendTheme ?? app(\App\Services\Branding\CompanyBrandingService::class)->getDefaultCssVariables();
    $seoData = $seo ?? [];
    $deferLandingBootstrap = trim($__env->yieldContent('defer_bootstrap')) === 'true';
    $sectionTitle = trim($__env->yieldContent('seo_title'));
    $sectionDescription = trim($__env->yieldContent('seo_description'));
    $sectionRobots = trim($__env->yieldContent('seo_robots'));
    $seoTitle = $seoData['title'] ?? ($sectionTitle !== '' ? $sectionTitle : $companyTitle);
    $seoDescription = $seoData['description'] ?? ($sectionDescription !== '' ? $sectionDescription : $companyDescription);
    $seoCanonical = $seoData['canonical'] ?? app(\App\Services\SeoMetadataService::class)->canonicalForCurrentPath();
    $seoImage = $seoData['image'] ?? $companyLogoUrl;
    $seoType = $seoData['type'] ?? 'website';
    $seoRobots = $seoData['robots'] ?? ($sectionRobots !== ''
        ? $sectionRobots
        : (\App\Services\InmobiliariaService::indexingEnabled($inmo) ? 'index, follow' : 'noindex, nofollow'));
    $seoSchemas = $seoData['schema'] ?? [];
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo e($seoTitle); ?></title>
    <meta name="description" content="<?php echo e($seoDescription); ?>">
    <meta name="robots" content="<?php echo e($seoRobots); ?>">
    <meta name="keywords" content="<?php echo e($companyKeywords); ?>">
    <link rel="canonical" href="<?php echo e($seoCanonical); ?>" />
    <?php if($searchConsoleVerificationToken = \App\Services\InmobiliariaService::searchConsoleVerificationToken($inmo)): ?>
        <meta name="google-site-verification" content="<?php echo e($searchConsoleVerificationToken); ?>">
    <?php endif; ?>

    <?php if($companyFaviconUrl): ?>
        <link rel="shortcut icon" href="<?php echo e($companyFaviconUrl); ?>" type="image/x-icon" />
    <?php endif; ?>

    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo e($seoTitle); ?>">
    <meta property="og:description" content="<?php echo e($seoDescription); ?>">
    <meta property="og:type" content="<?php echo e($seoType); ?>">
    <meta property="og:url" content="<?php echo e($seoCanonical); ?>">
    <meta property="og:site_name" content="<?php echo e($companyTitle); ?>">
    <?php if($seoImage): ?>
        <meta property="og:image" content="<?php echo e($seoImage); ?>">
    <?php endif; ?>
    <meta name="twitter:card" content="<?php echo e($seoImage ? 'summary_large_image' : 'summary'); ?>">
    <meta name="twitter:title" content="<?php echo e($seoTitle); ?>">
    <meta name="twitter:description" content="<?php echo e($seoDescription); ?>">
    <?php if($seoImage): ?>
        <meta name="twitter:image" content="<?php echo e($seoImage); ?>">
    <?php endif; ?>

    <?php $__currentLoopData = $seoSchemas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seoSchema): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script type="application/ld+json"><?php echo json_encode($seoSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if (! ($deferLandingBootstrap)): ?>
        <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Bootstrap no forma parte de la ruta de estilos de la home. -->
    <?php if (! ($deferLandingBootstrap)): ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-5.3.2.min.css')); ?>">
    <?php endif; ?>
    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=optional"
        onload="this.onload=null;this.rel='stylesheet'">
    <!-- Los iconos de la home se cargan después del primer paint. -->
    <?php if (! ($deferLandingBootstrap)): ?>
        <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
            onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        </noscript>
    <?php endif; ?>
    <noscript>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=optional">
    </noscript>

    <?php echo \Livewire\Livewire::styles(); ?>


    <style>
        /* ===========================
           TOKENS DE DISEÑO
        =========================== */
        :root {
            <?php $__currentLoopData = $themeVariables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($variable); ?>: <?php echo e($value); ?>;
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            --ff-head: 'Playfair Display',
            Georgia,
            serif;
            --ff-body: 'Inter',
            system-ui,
            sans-serif;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, .06);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, .10);
            --shadow-lg: 0 8px 40px rgba(0, 0, 0, .14);
            --radius: 12px;
            --radius-sm: 8px;
            --transition: color .25s ease, background-color .25s ease, border-color .25s ease,
                box-shadow .25s ease, opacity .25s ease, transform .25s ease;
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

        .skip-link {
            position: fixed;
            top: .75rem;
            left: .75rem;
            z-index: 10000;
            padding: .7rem 1rem;
            border-radius: .5rem;
            color: #fff;
            background: #111827;
            transform: translateY(-160%);
        }

        .skip-link:focus {
            transform: translateY(0);
        }

        img {
            max-width: 100%;
        }

        .fa, .fas, .far, .fab, .fa-solid, .fa-regular, .fa-brands {
            display: inline-block;
            width: 1em;
            text-align: center;
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
            background: rgba(var(--clr-accent-rgb), .08);
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

    </style>
    <?php if (! ($deferLandingBootstrap)): ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/landing-shared-v1.min.css')); ?>">
    <?php endif; ?>

    <?php echo $__env->yieldContent('extra_styles'); ?>
</head>

<body>

    <a class="skip-link" href="#main-content">Saltar al contenido principal</a>

    <!-- ===================== NAVBAR ===================== -->
    <nav class="navbar navbar-expand-lg navbar-landing" aria-label="Navegación principal">
        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>" aria-label="Inicio">
                <?php if($companyLogoUrl): ?>
                    <img src="<?php echo e($companyLogoUrl); ?>" alt="<?php echo e($companyTitle); ?>" width="48" height="48"
                        loading="eager" fetchpriority="high" decoding="async"
                        onerror="this.onerror=null;this.src='<?php echo e($companyLogoPlaceholder); ?>';">
                <?php else: ?>
                    <span class="brand-text"><?php echo e($companyTitle); ?></span>
                <?php endif; ?>
            </a>

            <!-- Mobile toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navLanding"
                aria-controls="navLanding" aria-expanded="false" aria-label="Abrir menú">
                <span class="navbar-toggler-icon" aria-hidden="true"></span>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="navLanding">
                <ul class="navbar-nav mx-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>"
                            href="<?php echo e(route('home')); ?>">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('listapropiedades') ? 'active' : ''); ?>"
                            href="<?php echo e(route('listapropiedades')); ?>">Propiedades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('equipo') ? 'active' : ''); ?>"
                            href="<?php echo e(route('equipo')); ?>">Agentes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('quienessomos') ? 'active' : ''); ?>"
                            href="<?php echo e(route('quienessomos')); ?>">Quiénes Somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('blog') ? 'active' : ''); ?>"
                            href="<?php echo e(route('blog')); ?>">Novedades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('contactos') ? 'active' : ''); ?>"
                            href="<?php echo e(route('contactos')); ?>">Contacto</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <a href="<?php echo e(route('login')); ?>" class="nav-link btn-nav-login">
                        <i class="fa-regular fa-user me-1"></i> Ingresar
                    </a>
                    <a href="<?php echo e(route('contactos')); ?>" class="nav-link btn-nav-publish">
                        Publica tu propiedad
                    </a>
                </div>
            </div>

        </div>
    </nav>
    <!-- FIN NAVBAR -->
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/layout/encabezado-landing.blade.php ENDPATH**/ ?>