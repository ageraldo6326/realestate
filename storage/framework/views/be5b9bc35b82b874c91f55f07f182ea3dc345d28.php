

<?php $__env->startSection('title', 'Disponible Para'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item active">Disponible para</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Disponible Para'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-3">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('buscar-disponible-para')->html();
} elseif ($_instance->childHasBeenRendered('PbLB17l')) {
    $componentId = $_instance->getRenderedChildComponentId('PbLB17l');
    $componentTag = $_instance->getRenderedChildComponentTagName('PbLB17l');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('PbLB17l');
} else {
    $response = \Livewire\Livewire::mount('buscar-disponible-para');
    $html = $response->html();
    $_instance->logRenderedChild('PbLB17l', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        livewire.on('generarBorrarDisponibleParaSweetAlert', id => {
            Swal.fire({
                title: '¿Borrar este registro ' + id + '?',
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
                    livewire.emit('borrarDisponiblePara', id);
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\disponiblepara\index.blade.php ENDPATH**/ ?>