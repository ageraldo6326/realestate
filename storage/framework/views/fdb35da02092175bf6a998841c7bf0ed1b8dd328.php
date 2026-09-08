

<?php $__env->startSection('seo_title', 'Quiénes Somos — ' . ($inmo->titulo ?? 'Portal Inmobiliario')); ?>
<?php $__env->startSection('seo_description', 'Conoce nuestra historia, misión y valores. Somos una inmobiliaria comprometida con tus sueños.'); ?>

<?php $__env->startSection('extra_styles'); ?>
<style>
    .page-hero { background: linear-gradient(135deg, var(--clr-dark) 0%, var(--clr-dark-2) 100%); padding: 3rem 0 2.5rem; }
    .page-hero .page-hero-title { font-family: var(--ff-head); font-size: clamp(1.8rem,4vw,2.4rem); color: var(--clr-white); font-weight: 700; margin-bottom: .5rem; }
    .page-hero .breadcrumb { background: transparent; padding: 0; margin: 0; font-size: .85rem; }
    .page-hero .breadcrumb-item a { color: var(--clr-accent); text-decoration: none; }
    .page-hero .breadcrumb-item.active { color: rgba(255,255,255,.7); }
    .page-hero .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,.4); }
    .about-section { padding: 4rem 0; background: var(--clr-bg); }
    .about-content-card {
        background: var(--clr-white);
        border-radius: var(--radius);
        border: 1px solid var(--clr-border);
        box-shadow: var(--shadow-sm);
        padding: 2.5rem 3rem;
        font-size: 1rem;
        line-height: 1.8;
        color: var(--clr-dark);
    }
    .about-content-card h2, .about-content-card h3 { font-family: var(--ff-head); color: var(--clr-dark); }
    .about-content-card img { max-width: 100%; border-radius: var(--radius-sm); }
    @media (max-width: 768px) { .about-content-card { padding: 1.5rem; } }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="page-hero" aria-label="Quiénes Somos">
    <div class="container">
        <h1 class="page-hero-title">Quiénes Somos</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Inicio</a></li>
                <li class="breadcrumb-item active">Quiénes Somos</li>
            </ol>
        </nav>
    </div>
</section>

<section class="about-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="about-content-card">
                    <?php echo $inmobiliaria->quienessomos; ?>

                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\frontend\quienessomos.blade.php ENDPATH**/ ?>