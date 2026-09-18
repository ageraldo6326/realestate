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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php echo \Livewire\Livewire::scripts(); ?>


<style>
    /* ===========================
       CTA BANNER
    =========================== */
    .cta-banner {
        background: #1E3A3A;
        padding: 4rem 0;
        overflow: hidden;
    }

    .cta-inner {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        gap: 2rem;
    }

    .cta-eyebrow {
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: 2px;
        color: var(--clr-accent);
        margin-bottom: .5rem;
    }

    .cta-title {
        font-family: var(--ff-head);
        font-size: clamp(1.6rem, 3.5vw, 2.4rem);
        color: var(--clr-white);
        font-weight: 700;
        line-height: 1.25;
        margin-bottom: .75rem;
    }

    .cta-desc {
        color: rgba(255, 255, 255, .7);
        font-size: .95rem;
    }

    .cta-image img {
        width: 260px;
        height: 200px;
        object-fit: cover;
        border-radius: var(--radius);
        opacity: .85;
    }

    .cta-action {
        text-align: right;
    }

    @media (max-width: 767px) {
        .cta-inner {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .cta-image {
            display: none;
        }

        .cta-action {
            text-align: center;
        }
    }

    /* ===========================
       FOOTER
    =========================== */
    .site-footer {
        background: var(--clr-dark);
        color: rgba(255, 255, 255, .7);
    }

    .footer-top {
        padding: 4rem 0 2.5rem;
    }

    .footer-brand {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .footer-brand-logo-wrap {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        align-self: flex-start;
        padding: .65rem 1.15rem;
        border-radius: 14px;
        overflow: hidden;
        text-decoration: none;
        background: linear-gradient(135deg, rgba(255, 255, 255, .16), rgba(255, 255, 255, .06));
        border: 1px solid rgba(255, 255, 255, .18);
        box-shadow: 0 12px 24px rgba(0, 0, 0, .18);
        backdrop-filter: blur(4px);
    }

    .footer-brand-logo {
        opacity: 1;
        max-width: 100%;
        width: auto;
        display: inline-block;
        max-height: 56px;
        object-fit: contain;
        border-radius: 10px;
    }

    .footer-brand-name {
        font-family: var(--ff-head);
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--clr-white);
    }

    .footer-tagline {
        font-size: .92rem;
        line-height: 1.6;
        color: rgba(255, 255, 255, .7);
        margin: 0;
        max-width: 320px;
        font-weight: 500;
        letter-spacing: .1px;
    }

    .footer-socials {
        display: flex;
        gap: .75rem;
        margin-top: .5rem;
    }

    .footer-socials a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 39px;
        height: 39px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, .22);
        color: rgba(255, 255, 255, .8);
        font-size: .88rem;
        text-decoration: none;
        transition: var(--transition);
        background: radial-gradient(circle at 30% 20%, rgba(255, 255, 255, .08), rgba(255, 255, 255, .02));
    }

    .footer-socials a:hover {
        border-color: rgba(201, 168, 76, .7);
        color: var(--clr-accent);
        background: rgba(201, 168, 76, .14);
        transform: translateY(-2px);
    }

    @media (max-width: 767px) {
        .footer-brand {
            align-items: center;
            text-align: center;
        }

        .footer-brand-logo-wrap {
            align-self: center;
        }

        .footer-tagline {
            max-width: 100%;
        }
    }

    .footer-heading {
        font-size: .85rem;
        font-weight: 700;
        color: var(--clr-white);
        letter-spacing: .5px;
        text-transform: uppercase;
        margin-bottom: 1.25rem;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: .65rem;
    }

    .footer-links a {
        color: rgba(255, 255, 255, .55);
        text-decoration: none;
        font-size: .875rem;
        transition: color .2s;
    }

    .footer-links a:hover {
        color: var(--clr-accent);
    }

    .footer-contact {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: .85rem;
    }

    .footer-contact li {
        display: flex;
        align-items: flex-start;
        gap: .75rem;
        font-size: .875rem;
    }

    .footer-contact li i {
        color: var(--clr-accent);
        margin-top: .15rem;
        flex-shrink: 0;
        width: 14px;
    }

    .footer-contact a,
    .footer-contact span {
        color: rgba(255, 255, 255, .65);
        text-decoration: none;
        transition: color .2s;
        line-height: 1.4;
    }

    .footer-contact a:hover {
        color: var(--clr-accent);
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, .08);
        padding: 1.25rem 0;
        text-align: center;
    }

    .footer-bottom p {
        font-size: .8rem;
        color: rgba(255, 255, 255, .35);
        margin: 0;
    }
</style>

<?php echo $__env->yieldContent('extra_scripts'); ?>

</body>

</html>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/layout/footer-landing.blade.php ENDPATH**/ ?>