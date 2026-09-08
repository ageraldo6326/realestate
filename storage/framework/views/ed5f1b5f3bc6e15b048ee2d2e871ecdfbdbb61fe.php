<div <?php echo e($attributes->merge(['class' => "p-0 col-{$size}"])); ?>>

    <span class="nav-link">

        
        <?php if(isset($icon)): ?>
            <i class="<?php echo e($icon); ?>"></i>
        <?php endif; ?>

        
        <?php if(isset($title)): ?>
            <?php if(! empty($url)): ?>
                <a href="<?php echo e($url); ?>"><?php echo e($title); ?></a>
            <?php else: ?>
                <?php echo e($title); ?>

            <?php endif; ?>
        <?php endif; ?>

        
        <?php if(isset($text)): ?>
            <span class="<?php echo e($makeTextWrapperClass()); ?>">
                <?php echo e($text); ?>

            </span>
        <?php endif; ?>

    </span>

</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\vendor\jeroennoten\laravel-adminlte\resources\views\components\widget\profile-row-item.blade.php ENDPATH**/ ?>