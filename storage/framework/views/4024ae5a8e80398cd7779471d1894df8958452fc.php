<?php echo $__env->make('layout.encabezado-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<main id="main-content">
    <?php echo $__env->yieldContent('content'); ?>
</main>

<?php echo $__env->make('layout.footer-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/layout/layout-landing.blade.php ENDPATH**/ ?>