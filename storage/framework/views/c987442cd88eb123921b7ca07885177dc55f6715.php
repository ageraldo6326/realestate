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

    $companyFooterLogoUrl = $resolvePublicAssetUrl(optional($inmo)->logo);
    $companyLogoPlaceholder = asset('assets/inmobiliaria/logo.png');
    $ctaPlaceholder = asset('assets/prop-apto-1.jpg');
    $deferLandingBootstrap = trim($__env->yieldContent('defer_bootstrap')) === 'true';
?>

<!-- ===================== CTA BANNER ===================== -->
<section class="cta-banner" aria-label="Publica tu propiedad">
    <div class="container">
        <div class="cta-inner">
            <div class="cta-content">
                <p class="cta-eyebrow">¿TIENES UNA PROPIEDAD?</p>
                <h2 class="cta-title">Publica tu propiedad<br>y llega a más personas</h2>
                <p class="cta-desc">Es rápido, fácil y completamente gratis.</p>
            </div>
            <div class="cta-image">
                <img src="/img/cta-home.jpg" alt="Publica tu propiedad" loading="lazy"
                    onerror="this.onerror=null;this.src='<?php echo e($ctaPlaceholder); ?>';">
            </div>
            <div class="cta-action">
                <a href="<?php echo e(route('contactos')); ?>" class="btn-accent">
                    Publicar ahora <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===================== FOOTER ===================== -->
<footer class="site-footer" aria-label="Pie de página">

    <div class="footer-top">
        <div class="container">
            <div class="row g-4">

                <!-- Brand column -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <?php if($companyFooterLogoUrl): ?>
                            <a href="<?php echo e(route('home')); ?>" aria-label="Inicio" class="footer-brand-logo-wrap">
                                <img src="<?php echo e($companyFooterLogoUrl); ?>" alt="<?php echo e(optional($inmo)->titulo ?? 'Logo'); ?>"
                                    class="footer-brand-logo" height="50" loading="lazy"
                                    onerror="this.onerror=null;this.src='<?php echo e($companyLogoPlaceholder); ?>';">
                            </a>
                        <?php else: ?>
                            <span class="footer-brand-name"><?php echo e(optional($inmo)->titulo ?? 'Inmobiliaria'); ?></span>
                        <?php endif; ?>

                        <p class="footer-tagline">
                            <?php echo e(optional($inmo)->slogan ?? 'Hacemos realidad el sueño de encontrar el hogar perfecto para ti y tu familia.'); ?>

                        </p>

                        <div class="footer-socials">
                            <?php if(isset($inmo->facebook) && $inmo->facebook): ?>
                                <a href="<?php echo e($inmo->facebook); ?>" aria-label="Facebook" target="_blank"
                                    rel="noopener noreferrer">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            <?php endif; ?>
                            <?php if(isset($inmo->instagram) && $inmo->instagram): ?>
                                <a href="<?php echo e($inmo->instagram); ?>" aria-label="Instagram" target="_blank"
                                    rel="noopener noreferrer">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            <?php endif; ?>
                            <?php if(isset($inmo->whatsapp) && $inmo->whatsapp): ?>
                                <a href="<?php echo e($inmo->whatsapp); ?>" aria-label="WhatsApp" target="_blank"
                                    rel="noopener noreferrer">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            <?php endif; ?>
                            <?php if(isset($inmo->tiktok) && $inmo->tiktok): ?>
                                <a href="<?php echo e($inmo->tiktok); ?>" aria-label="TikTok" target="_blank"
                                    rel="noopener noreferrer">
                                    <i class="fab fa-tiktok"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Navega column -->
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <h3 class="footer-heading">Navega</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo e(route('listapropiedades')); ?>">Propiedades</a></li>
                        <li><a href="<?php echo e(route('equipo')); ?>">Agentes</a></li>
                        <li><a href="<?php echo e(route('quienessomos')); ?>">Quiénes Somos</a></li>
                        <li><a href="<?php echo e(route('blog')); ?>">Novedades</a></li>
                        <li><a href="<?php echo e(route('contactos')); ?>">Contacto</a></li>
                    </ul>
                </div>

                <!-- Ayuda column -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <h3 class="footer-heading">Ayuda</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo e(route('contactos')); ?>">Preguntas frecuentes</a></li>
                        <li><a href="<?php echo e(route('contactos')); ?>">Guías</a></li>
                        <li><a href="<?php echo e(route('contactos')); ?>">Políticas</a></li>
                        <li><a href="<?php echo e(route('contactos')); ?>">Términos y condiciones</a></li>
                        <li><a href="<?php echo e(route('contactos')); ?>">Contacto</a></li>
                    </ul>
                </div>

                <!-- Contacto column -->
                <div class="col-lg-3 col-md-6">
                    <h3 class="footer-heading">Contacto</h3>
                    <ul class="footer-contact">
                        <?php if(isset($inmo->telefono) && $inmo->telefono): ?>
                            <li>
                                <i class="fas fa-phone"></i>
                                <a href="tel:<?php echo e($inmo->telefono); ?>"><?php echo e($inmo->telefono); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(isset($inmo->correo) && $inmo->correo): ?>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:<?php echo e($inmo->correo); ?>"><?php echo e($inmo->correo); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(isset($inmo->direccion) && $inmo->direccion): ?>
                            <li>
                                <i class="fas fa-location-dot"></i>
                                <span><?php echo e($inmo->direccion); ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e($inmo->titulo ?? 'Portal Inmobiliario'); ?>. Todos los derechos reservados.
            </p>
        </div>
    </div>

</footer>

<!-- ===================== SCRIPTS ===================== -->
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php echo \Livewire\Livewire::scripts(); ?>


<?php if($deferLandingBootstrap): ?>
    <script>
        (() => {
            const loadDeferredHomeStyles = () => requestAnimationFrame(() => requestAnimationFrame(() => {
                [
                    '<?php echo e(asset('css/home-framework-v1.min.css')); ?>',
                    '<?php echo e(asset('css/landing-shared-v1.min.css')); ?>',
                    '<?php echo e(asset('css/home-non-critical-v1.min.css')); ?>',
                    '<?php echo e(asset('css/landing-footer-v1.min.css')); ?>',
                    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
                ].forEach((href) => {
                    const stylesheet = document.createElement('link');
                    stylesheet.rel = 'stylesheet';
                    stylesheet.href = href;
                    document.head.appendChild(stylesheet);
                });
            }));

            if (document.readyState === 'complete') {
                loadDeferredHomeStyles();
            } else {
                window.addEventListener('load', loadDeferredHomeStyles, { once: true });
            }
        })();
    </script>
    <noscript>
        <link rel="stylesheet" href="<?php echo e(asset('css/home-framework-v1.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/landing-shared-v1.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/home-non-critical-v1.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/landing-footer-v1.min.css')); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </noscript>
<?php endif; ?>

<?php if (! ($deferLandingBootstrap)): ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/landing-footer-v1.min.css')); ?>">
<?php endif; ?>

<?php echo $__env->yieldContent('extra_scripts'); ?>

</body>

</html>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/layout/footer-landing.blade.php ENDPATH**/ ?>