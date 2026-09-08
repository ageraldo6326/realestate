

<?php $__env->startSection('title', 'Asignar Contactos'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('clientes.index')); ?>">Contactos</a></li>
    <li class="breadcrumb-item active">Asignar</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Asignar Contactos'); ?>

<?php $__env->startSection('page_actions'); ?>
    <a href="<?php echo e(route('clientes.index')); ?>" class="btn btn-outline-secondary btn-sm">
        Volver a contactos
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .content-wrapper {
            background: linear-gradient(180deg, #f8fafc 0%, #eef4f7 100%);
        }

        .content {
            padding-top: .25rem;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-12">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('asignar-contacto')->html();
} elseif ($_instance->childHasBeenRendered('u9ddosU')) {
    $componentId = $_instance->getRenderedChildComponentId('u9ddosU');
    $componentTag = $_instance->getRenderedChildComponentTagName('u9ddosU');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('u9ddosU');
} else {
    $response = \Livewire\Livewire::mount('asignar-contacto');
    $html = $response->html();
    $_instance->logRenderedChild('u9ddosU', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
    $(document).ready(function () {
        // Aplicar máscara de dinero al campo de monto
        $('.monto').mask('000,000,000,000,000', { reverse: true });
    });
</script>
<script src="//unpkg.com/alpinejs" defer></script>
<script>




livewire.on('limpiarDescripcion', () => {  
    console.log('limpiarDescripcion');    
    editor.setData("");
});

window.livewire.on('editarDescripcion', valor => {  
    console.log('editarDescripcion');    
    editor.setData(valor);
});   

livewire.on('generarBorrarSweetAlert', (id, mensaje, metodo) => {

    Swal.fire({
        title: mensaje + id + '?',
        showCancelButton: true,
        cancelButtonText: `Cancelar`,
        confirmButtonText: 'Borrar',
        cancelButtonColor: "#3085d6",
        confirmButtonColor: "#d33",
        icon: 'warning',
        }).then((result) => {
        if (result.value==true) {
            Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Registro Eliminado",
            showConfirmButton: false,
            timer: 1500
            });                
            livewire.emit(metodo,id)
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })            

})
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\clientes\asignar.blade.php ENDPATH**/ ?>