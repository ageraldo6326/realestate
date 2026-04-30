



<?php $__env->startSection('galeria'); ?>
<div class="ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image "  data-bs-bg="img/bg/14.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title">404 Pagina no encontrada</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?php echo e(route('home')); ?>"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li>404</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/errors/404.blade.php ENDPATH**/ ?>