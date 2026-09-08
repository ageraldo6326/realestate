

<?php $__env->startSection('title', 'Tipos de Tarea'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item active">Tipos de tarea</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Tipos de Tarea'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-3">
        <?php if(session('status')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-3">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tipo-tareas')->html();
} elseif ($_instance->childHasBeenRendered('cAVazhU')) {
    $componentId = $_instance->getRenderedChildComponentId('cAVazhU');
    $componentTag = $_instance->getRenderedChildComponentTagName('cAVazhU');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('cAVazhU');
} else {
    $response = \Livewire\Livewire::mount('tipo-tareas');
    $html = $response->html();
    $_instance->logRenderedChild('cAVazhU', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        livewire.on('generarBorrarTipoTareaSweetAlert', (id, nombre) => {
            Swal.fire({
                title: 'Confirmar eliminacion',
                text: nombre ? `Se eliminara el tipo de tarea "${nombre}".` : 'Se eliminara el tipo de tarea seleccionado.',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Eliminar',
                cancelButtonColor: '#6c757d',
                confirmButtonColor: '#dc3545',
            }).then((result) => {
                if (result.isConfirmed) {
                    livewire.emit('borrarTipoTarea', id);
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\tipotarea\index.blade.php ENDPATH**/ ?>