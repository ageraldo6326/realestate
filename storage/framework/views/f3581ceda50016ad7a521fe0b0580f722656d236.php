<?php echo $__env->make('layout.encabezado', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <!-- SLIDER AREA -->

        <?php echo $__env->yieldContent('galeria'); ?>
   
    <!-- SLIDER AREA END -->

    <!-- PRODUCT SLIDER AREA START -->
        
        <?php echo $__env->yieldContent('propiedades_destacadas'); ?>
        
    <!-- PRODUCT SLIDER AREA END -->

    <!-- BUSCAR PROPIEDADES -->

        <?php echo $__env->yieldContent('buscar-propiedades'); ?>

    <!-- BUSCAR PROPIEDADES END -->

    <!-- COUNTER UP AREA START -->

        

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
<?php echo $__env->make('layout.footerHome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/layout/layout.blade.php ENDPATH**/ ?>