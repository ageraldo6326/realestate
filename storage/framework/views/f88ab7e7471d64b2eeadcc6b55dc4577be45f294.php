<div <?php echo e($attributes->merge(['class' => $makeCardClass()])); ?>>

    
    <?php if(! $isCardHeaderEmpty(isset($toolsSlot))): ?>
        <div class="<?php echo e($makeCardHeaderClass()); ?>">

            
            <h3 class="<?php echo e($makeCardTitleClass()); ?>">
                <?php if(isset($icon)): ?><i class="<?php echo e($icon); ?> mr-1"></i><?php endif; ?>
                <?php if(isset($title)): ?><?php echo e($title); ?><?php endif; ?>
            </h3>

            
            <div class="card-tools">

                
                <?php if(isset($toolsSlot)): ?>
                    <?php echo e($toolsSlot); ?>

                <?php endif; ?>

                
                <?php if(isset($maximizable)): ?>
                    <?php if (isset($component)) { $__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Button::class, ['theme' => 'tool','icon' => 'fas fa-lg fa-expand']); ?>
<?php $component->withName('adminlte-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-card-widget' => 'maximize']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806)): ?>
<?php $component = $__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806; ?>
<?php unset($__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806); ?>
<?php endif; ?>
                <?php endif; ?>

                <?php if($collapsible === 'collapsed'): ?>
                    <?php if (isset($component)) { $__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Button::class, ['theme' => 'tool','icon' => 'fas fa-lg fa-plus']); ?>
<?php $component->withName('adminlte-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-card-widget' => 'collapse']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806)): ?>
<?php $component = $__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806; ?>
<?php unset($__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806); ?>
<?php endif; ?>
                <?php elseif(isset($collapsible)): ?>
                    <?php if (isset($component)) { $__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Button::class, ['theme' => 'tool','icon' => 'fas fa-lg fa-minus']); ?>
<?php $component->withName('adminlte-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-card-widget' => 'collapse']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806)): ?>
<?php $component = $__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806; ?>
<?php unset($__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806); ?>
<?php endif; ?>
                <?php endif; ?>

                <?php if(isset($removable)): ?>
                    <?php if (isset($component)) { $__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Button::class, ['theme' => 'tool','icon' => 'fas fa-lg fa-times']); ?>
<?php $component->withName('adminlte-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-card-widget' => 'remove']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806)): ?>
<?php $component = $__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806; ?>
<?php unset($__componentOriginale79ddb0df6378beefa1143d3ec5f549fbb0da806); ?>
<?php endif; ?>
                <?php endif; ?>

            </div>

        </div>
    <?php endif; ?>

    
    <?php if(! $slot->isEmpty()): ?>
        <div class="<?php echo e($makeCardBodyClass()); ?>">
            <?php echo e($slot); ?>

        </div>
    <?php endif; ?>

    
    <?php if(isset($footerSlot)): ?>
        <div class="<?php echo e($makeCardFooterClass()); ?>">
            <?php echo e($footerSlot); ?>

        </div>
    <?php endif; ?>

    
    <?php if($disabled): ?>
        <div class="overlay">
            <i class="fas fa-2x fa-ban text-gray"></i>
        </div>
    <?php endif; ?>

</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\vendor\jeroennoten\laravel-adminlte\resources\views\components\widget\card.blade.php ENDPATH**/ ?>