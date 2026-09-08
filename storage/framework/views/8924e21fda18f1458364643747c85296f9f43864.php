

<?php $__env->startSection('title', 'Contactos'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active">Contactos</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Contactos'); ?>

<?php $__env->startSection('content'); ?>

    <div class="container-fluid px-3">
        <div class="card border-0 shadow-sm mb-3 overflow-hidden">
            <div class="card-body py-3" style="background: linear-gradient(120deg, #0f172a, #1e3a8a); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <h2 class="h4 mb-1 font-weight-bold">Gestion de Contactos</h2>
                        <p class="mb-0" style="opacity: .85;">Administra, segmenta y da seguimiento a prospectos desde un solo panel.</p>
                    </div>
                    <div class="d-flex align-items-center" style="opacity: .9;">
                        <i class="fas fa-address-book mr-2"></i>
                        <span>CRM comercial</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted text-uppercase small mb-1">Total</p>
                        <h3 class="mb-0"><?php echo e($stats['total'] ?? 0); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted text-uppercase small mb-1">Activos</p>
                        <h3 class="mb-0 text-success"><?php echo e($stats['activos'] ?? 0); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted text-uppercase small mb-1">Nuevos</p>
                        <h3 class="mb-0 text-info"><?php echo e($stats['nuevos'] ?? 0); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted text-uppercase small mb-1">Cierres</p>
                        <h3 class="mb-0 text-primary"><?php echo e($stats['cierres'] ?? 0); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('buscar-cliente')->html();
} elseif ($_instance->childHasBeenRendered('FbItMEV')) {
    $componentId = $_instance->getRenderedChildComponentId('FbItMEV');
    $componentTag = $_instance->getRenderedChildComponentTagName('FbItMEV');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('FbItMEV');
} else {
    $response = \Livewire\Livewire::mount('buscar-cliente');
    $html = $response->html();
    $_instance->logRenderedChild('FbItMEV', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        livewire.on('generarBorrarSweetAlert', (id, mensaje, metodo) => {
            Swal.fire({
                title: mensaje + id + '?',
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
                    livewire.emit(metodo, id);
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\clientes\index.blade.php ENDPATH**/ ?>