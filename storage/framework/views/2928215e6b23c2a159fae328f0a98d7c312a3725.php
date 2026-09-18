<?php $__env->startSection('seo_title', 'Página no encontrada'); ?>
<?php $__env->startSection('seo_description', 'La página solicitada no está disponible.'); ?>
<?php $__env->startSection('seo_robots', 'noindex, nofollow'); ?>

<?php $__env->startSection('content'); ?>
    <section class="py-5 bg-light" aria-labelledby="not-found-title">
        <div class="container py-5 text-center">
            <div class="display-1 fw-bold text-primary mb-3" aria-hidden="true">404</div>
            <h1 id="not-found-title" class="h2 mb-3">Página no encontrada</h1>
            <p class="text-muted mb-4">El enlace puede haber cambiado o el contenido ya no está disponible.</p>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary px-4">Volver al inicio</a>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.layout-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\errors\404.blade.php ENDPATH**/ ?>