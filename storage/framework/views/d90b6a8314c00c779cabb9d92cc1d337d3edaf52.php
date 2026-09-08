

<?php $__env->startSection('title', 'Registrar Venta'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('registrarventa')); ?>">Ventas</a></li>
    <li class="breadcrumb-item active">Registrar Venta</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Registrar Venta'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-3">

        <div class="card border-0 shadow-sm mb-3 overflow-hidden">
            <div class="card-body py-3" style="background: linear-gradient(120deg, #0f172a, #1e3a8a); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <h2 class="h4 mb-1 font-weight-bold">Registrar nueva venta</h2>
                        <p class="mb-0" style="opacity:.85;">Vincula una propiedad con vendedor, comprador y asesor para
                            cerrar el negocio.</p>
                    </div>
                    <div class="d-flex align-items-center" style="opacity:.9;">
                        <i class="fas fa-handshake mr-2"></i>
                        <span>CRM · Ventas</span>
                    </div>
                </div>
            </div>
        </div>

        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('crear-ventas')->html();
} elseif ($_instance->childHasBeenRendered('indilrS')) {
    $componentId = $_instance->getRenderedChildComponentId('indilrS');
    $componentTag = $_instance->getRenderedChildComponentTagName('indilrS');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('indilrS');
} else {
    $response = \Livewire\Livewire::mount('crear-ventas');
    $html = $response->html();
    $_instance->logRenderedChild('indilrS', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('ventaGrabada', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Venta registrada',
                    timer: 1800,
                    showConfirmButton: false
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\ventas\create.blade.php ENDPATH**/ ?>