

<?php $__env->startSection('title', 'Testimonios'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item active">Testimonios</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Testimonios'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-3">
        <style>
            .content-shell {
                display: grid;
                gap: 1rem;
            }

            .content-hero {
                background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
                border-radius: 1.25rem;
                color: #fff;
                padding: 1.5rem;
                box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
            }

            .content-panel {
                border: 1px solid #dbe4f0;
                border-radius: 1.25rem;
                box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
            }

            .content-avatar {
                width: 56px;
                height: 56px;
                object-fit: cover;
                border-radius: 999px;
                border: 2px solid #e2e8f0;
            }

            .content-actions {
                display: flex;
                justify-content: flex-end;
                flex-wrap: wrap;
                gap: 0.5rem;
            }
        </style>

        <div class="content-shell">
            <?php if(session('status')): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-lg mb-0"><?php echo e(session('status')); ?></div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-0"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <section class="content-hero">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div>
                        <h2 class="h4 mb-2 font-weight-bold">Testimonios</h2>
                        <p class="mb-0 text-white-50">Administra testimonios del portal con vistas dedicadas para crear y
                            editar.</p>
                    </div>
                    <div class="mt-3 mt-md-0 text-md-right">
                        <div class="text-uppercase small text-white-50">Registros encontrados</div>
                        <div class="h3 mb-0 font-weight-bold"><?php echo e($testimonios->total()); ?></div>
                    </div>
                </div>
            </section>

            <section class="card content-panel">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                        <div>
                            <h3 class="h5 mb-1">Listado de testimonios</h3>
                            <p class="text-muted mb-0">Busca por cliente, mensaje o ID.</p>
                        </div>
                        <a href="<?php echo e(route('testimonios.create')); ?>" class="btn btn-primary mt-3 mt-lg-0 px-4">Nuevo
                            testimonio</a>
                    </div>

                    <form method="GET" action="<?php echo e(route('testimonios.index')); ?>" class="row mb-4">
                        <div class="col-lg-8">
                            <label for="search" class="small text-muted font-weight-semibold">Buscar testimonio</label>
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control" id="search" name="search"
                                    value="<?php echo e($search); ?>" placeholder="Ej. Maria Perez o cliente satisfecho">
                                <div class="input-group-append ml-2">
                                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                                    <a href="<?php echo e(route('testimonios.index')); ?>"
                                        class="btn btn-outline-secondary ml-2">Limpiar</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="text-uppercase small text-muted">
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th class="d-none d-md-table-cell">Testimonio</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $testimonios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="font-weight-semibold"><?php echo e($testimonio->id); ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if($testimonio->cliente_foto): ?>
                                                    <img src="<?php echo e(asset(ltrim($testimonio->cliente_foto, '/'))); ?>"
                                                        class="content-avatar mr-3" alt="<?php echo e($testimonio->cliente); ?>">
                                                <?php endif; ?>
                                                <div>
                                                    <div class="font-weight-semibold"><?php echo e($testimonio->cliente); ?></div>
                                                    <div class="small text-muted">
                                                        <?php echo e($testimonio->activo ? 'Visible' : 'Oculto'); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell text-muted">
                                            <?php echo e(\Illuminate\Support\Str::limit(strip_tags($testimonio->testimonio), 90)); ?>

                                        </td>
                                        <td class="text-right">
                                            <div class="content-actions">
                                                <a href="<?php echo e(route('testimonios.edit', $testimonio)); ?>"
                                                    class="btn btn-outline-primary btn-sm">Editar</a>
                                                <form action="<?php echo e(route('testimonios.destroy', $testimonio)); ?>"
                                                    method="POST" class="js-delete-form"
                                                    data-name="<?php echo e($testimonio->cliente); ?>">
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
                                        <td colspan="4" class="text-center py-5 text-muted">No hay testimonios para
                                            mostrar con el criterio actual.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4"><?php echo e($testimonios->links('pagination::bootstrap-4')); ?></div>
                </div>
            </section>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.js-delete-form').forEach((form) => {
                form.addEventListener('submit', (event) => {
                    event.preventDefault();

                    Swal.fire({
                        title: '¿Eliminar este testimonio?',
                        text: form.dataset.name || 'Esta accion no se puede deshacer.',
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Eliminar',
                        cancelButtonColor: '#6c757d',
                        confirmButtonColor: '#dc3545',
                        icon: 'warning',
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

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/admin/testimonios/index.blade.php ENDPATH**/ ?>