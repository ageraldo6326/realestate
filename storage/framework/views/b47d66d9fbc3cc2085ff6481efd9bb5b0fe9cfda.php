

<?php $__env->startSection('title', 'Usuarios'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Configuración</li>
    <li class="breadcrumb-item active">Usuarios</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Usuarios'); ?>

<?php $__env->startSection('content'); ?>

    <div class="container-fluid px-3">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('buscar-usuario')->html();
} elseif ($_instance->childHasBeenRendered('9Fp9E4Y')) {
    $componentId = $_instance->getRenderedChildComponentId('9Fp9E4Y');
    $componentTag = $_instance->getRenderedChildComponentTagName('9Fp9E4Y');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('9Fp9E4Y');
} else {
    $response = \Livewire\Livewire::mount('buscar-usuario');
    $html = $response->html();
    $_instance->logRenderedChild('9Fp9E4Y', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        livewire.on('generarBorrarUsuarioSweetAlert', id => {
            Swal.fire({
                title: '¿Borrar el usuario ' + id + '?',
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
                    livewire.emit('borrarUsuario', id);
                }
            });
        });

        livewire.on('generarRestaurarUsuarioSweetAlert', (id, nombre) => {
            Swal.fire({
                title: '¿Restaurar a ' + nombre + '?',
                text: 'El usuario volverá a estar activo en el sistema.',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Restaurar',
                cancelButtonColor: '#6c757d',
                confirmButtonColor: '#28a745',
                icon: 'question',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Usuario restaurado',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    livewire.emit('restaurarUsuario', id);
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\usuarios\index.blade.php ENDPATH**/ ?>