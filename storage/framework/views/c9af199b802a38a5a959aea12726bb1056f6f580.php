

<?php $__env->startSection('title', 'Estados'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item active">Estados</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Estados'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .estados-shell {
            display: grid;
            gap: 1rem;
        }

        .estados-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .estados-stat {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 1rem;
            padding: 1rem;
        }

        .estados-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }
    </style>

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

        <div class="estados-shell">
            <section class="estados-hero">
                <div class="row align-items-end">
                    <div class="col-lg-8 mb-3 mb-lg-0">
                        <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">Catálogos del CRM</span>
                        <h2 class="h3 font-weight-bold mb-2">Gestión de estados comerciales</h2>
                        <p class="mb-0 text-white-50">Filtra por nombre o ID, crea o edita estados en pantallas dedicadas sin perder el contexto del listado.</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="estados-stat">
                            <div class="text-uppercase small text-white-50">Estados encontrados</div>
                            <div class="h3 mb-0 font-weight-bold"><?php echo e($estados->total()); ?></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="card estados-panel">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                        <div>
                            <h3 class="h5 mb-1">Listado de estados</h3>
                            <p class="text-muted mb-0">Gestiona los estados comerciales de las propiedades del sistema.</p>
                        </div>
                        <a href="<?php echo e(route('estados.create')); ?>" class="btn btn-primary mt-3 mt-lg-0 px-4">
                            Nuevo estado
                        </a>
                    </div>

                    <form action="<?php echo e(route('estados.index')); ?>" method="GET" autocomplete="off">
                        <div class="row mb-4">
                            <div class="col-lg-8">
                                <label for="filtro-estado" class="small text-muted font-weight-semibold">Buscar estado</label>
                                <input type="text" id="filtro-estado" name="q" value="<?php echo e($filtro); ?>"
                                    class="form-control form-control-lg rounded-lg" maxlength="50"
                                    placeholder="Ej. Disponible o ID 3">
                            </div>
                            <div class="col-lg-4 d-flex align-items-end mt-3 mt-lg-0">
                                <button type="submit" class="btn btn-outline-primary mr-2">Buscar</button>
                                <a href="<?php echo e(route('estados.index')); ?>" class="btn btn-outline-secondary">Limpiar</a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="text-uppercase small text-muted">
                                <tr>
                                    <th>ID</th>
                                    <th>Estado</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="font-weight-bold"><?php echo e($estado->id); ?></td>
                                        <td>
                                            <div class="font-weight-semibold"><?php echo e($estado->estado); ?></div>
                                        </td>
                                        <td class="text-right">
                                            <div class="d-flex justify-content-end">
                                                <a href="<?php echo e(route('estados.edit', $estado)); ?>"
                                                    class="btn btn-outline-primary btn-sm mr-1">Editar</a>

                                                <form action="<?php echo e(route('estados.destroy', $estado)); ?>" method="POST"
                                                    class="d-inline js-form-delete-estado"
                                                    data-estado="<?php echo e($estado->estado); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit"
                                                        class="btn btn-outline-danger btn-sm">Eliminar</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted">
                                            No hay estados registrados con ese criterio.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <?php echo e($estados->links('pagination::bootstrap-4')); ?>

                    </div>
                </div>
            </section>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.js-form-delete-estado').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const nombre = this.dataset.estado || 'este estado';
                    Swal.fire({
                        title: '¿Eliminar "' + nombre + '"?',
                        text: 'Esta acción no se puede deshacer.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Eliminar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                    }).then(result => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const forms = document.querySelectorAll('.js-form-delete-estado');

            forms.forEach((form) => {
                form.addEventListener('submit', (event) => {
                    event.preventDefault();

                    const estado = form.dataset.estado || '';

                    Swal.fire({
                        title: 'Confirmar eliminación',
                        text: estado ? `Se eliminará el estado "${estado}".` :
                            'Se eliminará el estado seleccionado.',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Eliminar',
                        cancelButtonColor: '#6c757d',
                        confirmButtonColor: '#dc3545',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\estados\index.blade.php ENDPATH**/ ?>