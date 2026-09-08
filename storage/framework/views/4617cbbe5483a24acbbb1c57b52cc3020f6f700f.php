

<?php $__env->startSection('title', 'Revision de Contactos'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('clientes.index')); ?>">Contactos</a></li>
    <li class="breadcrumb-item active">Revision</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Revision de Contactos'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-3">
        <div class="card border-0 shadow-sm mb-3 overflow-hidden">
            <div class="card-body py-3" style="background: linear-gradient(120deg, #052e16, #166534); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <h2 class="h4 mb-1 font-weight-bold">Verificacion de Contactos</h2>
                        <p class="mb-0" style="opacity: .85;">Busca por telefono o correo para evitar duplicados y verificar asignacion.</p>
                    </div>
                    <div class="d-flex align-items-center" style="opacity: .9;">
                        <i class="fas fa-search mr-2"></i>
                        <span>Control de calidad CRM</span>
                    </div>
                </div>
            </div>
        </div>

        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('consultar-cliente')->html();
} elseif ($_instance->childHasBeenRendered('mcjJWWd')) {
    $componentId = $_instance->getRenderedChildComponentId('mcjJWWd');
    $componentTag = $_instance->getRenderedChildComponentTagName('mcjJWWd');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('mcjJWWd');
} else {
    $response = \Livewire\Livewire::mount('consultar-cliente');
    $html = $response->html();
    $_instance->logRenderedChild('mcjJWWd', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\clientes\verificar.blade.php ENDPATH**/ ?>