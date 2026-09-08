

<?php $__env->startSection('title', 'Ventas'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">CRM</a></li>
    <li class="breadcrumb-item active">Ventas</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Registro de ventas'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-3">
        <div class="card border-0 shadow-sm overflow-hidden mb-3">
            <div class="card-body py-4" style="background: linear-gradient(135deg, #1f2937, #0f766e); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-uppercase small mb-2" style="letter-spacing:.14em; opacity:.75;">Cierres y seguimiento</p>
                        <h2 class="h4 font-weight-bold mb-1">Monitorea ventas cerradas y operaciones en curso</h2>
                        <p class="mb-0" style="opacity:.82; max-width:42rem;">Consulta rápidamente asesores, propiedades, compradores y fechas de cierre desde una sola pantalla.</p>
                    </div>
                    <a href="<?php echo e(route('crearventa')); ?>" class="btn btn-light btn-sm">
                        <i class="fas fa-plus mr-1"></i> Registrar venta
                    </a>
                </div>
            </div>
        </div>

        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registrar-ventas')->html();
} elseif ($_instance->childHasBeenRendered('cfeLyBU')) {
    $componentId = $_instance->getRenderedChildComponentId('cfeLyBU');
    $componentTag = $_instance->getRenderedChildComponentTagName('cfeLyBU');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('cfeLyBU');
} else {
    $response = \Livewire\Livewire::mount('registrar-ventas');
    $html = $response->html();
    $_instance->logRenderedChild('cfeLyBU', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\ventas\registrarventas.blade.php ENDPATH**/ ?>