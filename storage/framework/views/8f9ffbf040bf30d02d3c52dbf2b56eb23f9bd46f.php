

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Dashboard</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row justify-content-center">
    <div class="col-md-12">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('buscar-inmobiliaria')->html();
} elseif ($_instance->childHasBeenRendered('M040l6x')) {
    $componentId = $_instance->getRenderedChildComponentId('M040l6x');
    $componentTag = $_instance->getRenderedChildComponentTagName('M040l6x');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('M040l6x');
} else {
    $response = \Livewire\Livewire::mount('buscar-inmobiliaria');
    $html = $response->html();
    $_instance->logRenderedChild('M040l6x', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked+.slider {
    background-color: #2196F3;
}

input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}    

.zoom {
    padding: 0px;
    transition: transform .2s;
    margin: 0 auto;
}

.zoom:hover {
    transform: scale(2); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    
livewire.on('limpiarQuienesSomos', () => {  
    console.log('limpiarQuienesSomos');    
    editor.setData("");
});

window.livewire.on('editarQuienesSomos', valor => {  
    console.log('editarQuienesSomos');    
    editor.setData(valor);
});   
</script>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\empresa\index.blade.php ENDPATH**/ ?>