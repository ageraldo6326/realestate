<?php echo $__env->make('layout.encabezadoContactos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <!-- SLIDER AREA -->

        <?php echo $__env->yieldContent('galeria'); ?>
   
    <!-- SLIDER AREA END -->

    <!-- PRODUCT SLIDER AREA START -->

        <?php echo $__env->yieldContent('propiedades_destacadas'); ?>

    <!-- PRODUCT SLIDER AREA END -->    

    <!-- COUNTER UP AREA START -->

        <?php echo $__env->yieldContent('counter'); ?>

    <!-- COUNTER UP AREA END -->

  
    <!-- TESTIMONIAL AREA START (testimonial-7) -->
                
        <?php echo $__env->yieldContent('testimonios'); ?>

    <!-- TESTIMONIAL AREA END -->


    <!-- FEATURE AREA START ( Feature - 6) -->

        <?php echo $__env->yieldContent('enfoque'); ?>

    <!-- FEATURE AREA END -->


    <!-- Blog Item -->

        <?php echo $__env->yieldContent('blog'); ?>

    <!-- Blog Item -->


    <!-- CALL TO ACTION START (call-to-action-6) -->
<?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\layout\layoutContactos.blade.php ENDPATH**/ ?>