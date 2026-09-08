<div <?php echo e($attributes->merge(['class' => "col-{$size}"])); ?>>

    <div class="description-block">

        
        <?php if(isset($icon)): ?>
            <i class="<?php echo e($icon); ?>"></i>
        <?php endif; ?>

        
        <?php if(isset($title)): ?>
            <h5 class="description-header">
                <?php if(! empty($url)): ?>
                    <a href="<?php echo e($url); ?>"><?php echo e($title); ?></a>
                <?php else: ?>
                    <?php echo e($title); ?>

                <?php endif; ?>
            </h5>
        <?php endif; ?>

        
        <?php if(isset($text)): ?>
            <p class="description-text">
                <span class="<?php echo e($makeTextWrapperClass()); ?>">
                    <?php echo e($text); ?>

                </span>
            </p>
        <?php endif; ?>

    </div>

</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\vendor\jeroennoten\laravel-adminlte\resources\views\components\widget\profile-col-item.blade.php ENDPATH**/ ?>