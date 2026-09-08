

<?php $__env->startSection('title', 'Tipos de Propiedad'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item active">Tipos de propiedad</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Tipos de Propiedad'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-3">
        
        <?php if(session('success')): ?>
            <div class="alert alert-success shadow-sm border-0 rounded-lg">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger shadow-sm border-0 rounded-lg">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('buscar-tipo-propiedad')->html();
} elseif ($_instance->childHasBeenRendered('R55SfJU')) {
    $componentId = $_instance->getRenderedChildComponentId('R55SfJU');
    $componentTag = $_instance->getRenderedChildComponentTagName('R55SfJU');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('R55SfJU');
} else {
    $response = \Livewire\Livewire::mount('buscar-tipo-propiedad');
    $html = $response->html();
    $_instance->logRenderedChild('R55SfJU', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('generarBorrarSweetAlert', (id) => {
                Swal.fire({
                    title: '¿Eliminar tipo de propiedad?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Eliminar',
                    cancelButtonColor: '#6c757d',
                    confirmButtonColor: '#dc3545',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('borrarTipoPropiedad', id);
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\tipopropiedades\index.blade.php ENDPATH**/ ?>