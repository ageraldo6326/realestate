

<?php $__env->startSection('title', 'Propiedades'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active">Mis propiedades</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Mis propiedades'); ?>

<?php $__env->startSection('content'); ?>

    <div class="container-fluid px-3">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('buscar-propiedad')->html();
} elseif ($_instance->childHasBeenRendered('45jnP2g')) {
    $componentId = $_instance->getRenderedChildComponentId('45jnP2g');
    $componentTag = $_instance->getRenderedChildComponentTagName('45jnP2g');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('45jnP2g');
} else {
    $response = \Livewire\Livewire::mount('buscar-propiedad');
    $html = $response->html();
    $_instance->logRenderedChild('45jnP2g', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        livewire.on('generarBorrarPropiedadSweetAlert', id => {
            Swal.fire({
                title: '¿Borrar la propiedad ' + id + '?',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Borrar',
                cancelButtonColor: '#6c757d',
                confirmButtonColor: '#dc3545',
                icon: 'warning',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registro eliminado',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    livewire.emit('borrarPropiedad', id);
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\propiedades\index.blade.php ENDPATH**/ ?>