<div>
    <style>
        .users-shell {
            display: grid;
            gap: 1rem;
        }

        .users-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .users-stat {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 1rem;
            padding: 1rem;
        }

        .users-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
        }

        .users-avatar {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 999px;
            border: 2px solid #e2e8f0;
        }
    </style>

    <?php if(session('status')): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <div class="users-shell">
        <section class="users-hero">
            <div class="row align-items-end">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">Configuracion del CRM</span>
                    <h2 class="h3 font-weight-bold mb-2">Gestion de usuarios con panel modernizado y formularios
                        dedicados.</h2>
                    <p class="mb-0 text-white-50">Filtra por nombre o ID, revisa estado y entra a crear o editar en
                        pantallas separadas sin perder el contexto del listado.</p>
                </div>
                <div class="col-lg-4">
                    <div class="users-stat">
                        <div class="text-uppercase small text-white-50">Usuarios encontrados</div>
                        <div class="h3 mb-0 font-weight-bold"><?php echo e($usuarios->total()); ?></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="card users-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Listado de usuarios</h3>
                        <p class="text-muted mb-0">Gestiona el directorio, entra a crear o editar en vistas dedicadas y
                            conserva la busqueda en esta pantalla.</p>
                    </div>
                    <a href="<?php echo e(route('usuarios.create')); ?>" class="btn btn-primary mt-3 mt-lg-0 px-4">
                        Nuevo usuario
                    </a>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <label class="small text-muted font-weight-semibold">Buscar usuario</label>
                        <input id="user-search-input" name="user_search_filter" type="search"
                            class="form-control form-control-lg rounded-lg" wire:model.debounce.350ms="criterio"
                            placeholder="Ej. Maria Perez o ID 25" autocomplete="new-password" autocorrect="off"
                            autocapitalize="off" spellcheck="false" readonly
                            onfocus="this.removeAttribute('readonly');">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-uppercase small text-muted">
                            <tr>
                                <th>Usuario</th>
                                <th class="d-none d-md-table-cell">Contacto</th>
                                <th class="d-none d-lg-table-cell">Estado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_2 = true; $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <?php
                                    $userIsAdmin = (int) $usuario->rol === 1;
                                    $isProtectedSuperadmin =
                                        $usuario->isConfiguredSuperadmin() && !$allowSuperadminMutations;
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo e($usuario->resolvePhotoUrl()); ?>" alt="<?php echo e($usuario->name); ?>"
                                                class="users-avatar mr-3">
                                            <div>
                                                <div class="font-weight-bold"><?php echo e($usuario->name); ?></div>
                                                <div class="small text-muted">ID: <?php echo e($usuario->id); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <div class="font-weight-semibold"><?php echo e($usuario->email ?: 'Sin correo'); ?></div>
                                        <div class="small text-muted"><?php echo e($usuario->telefono ?: 'Sin telefono'); ?></div>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <span
                                            class="badge badge-pill <?php echo e((int) $usuario->activo === 1 ? 'badge-success' : 'badge-secondary'); ?> mr-2">
                                            <?php echo e((int) $usuario->activo === 1 ? 'Activo' : 'Inactivo'); ?>

                                        </span>
                                        <span
                                            class="badge badge-pill <?php echo e($userIsAdmin ? 'badge-info' : 'badge-light'); ?>">
                                            <?php echo e($userIsAdmin ? 'Administrador' : 'Asesor'); ?>

                                        </span>
                                        <?php if($isProtectedSuperadmin): ?>
                                            <span class="badge badge-pill badge-warning ml-2">Superadmin
                                                protegido</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right">
                                        <div class="d-flex justify-content-end">
                                            <a href="<?php echo e(route('usuarios.edit', $usuario->id)); ?>"
                                                class="btn btn-outline-primary btn-sm mr-1">
                                                Editar
                                            </a>
                                            <?php if($isProtectedSuperadmin): ?>
                                                <button type="button" class="btn btn-outline-secondary btn-sm" disabled
                                                    title="Superadmin protegido">
                                                    Borrar bloqueado
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    wire:click="$emit('generarBorrarUsuarioSweetAlert', <?php echo e($usuario->id); ?>)"
                                                    data-element-id="<?php echo e($usuario->id); ?>">
                                                    Borrar
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        No hay usuarios para mostrar con el criterio actual.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <?php echo e($usuarios->links()); ?>

                </div>
            </div>
        </section>

        <?php if($usuariosEliminados->isNotEmpty()): ?>
            <section class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-light border-0 d-flex align-items-center">
                    <span class="badge badge-secondary mr-2"><?php echo e($usuariosEliminados->count()); ?></span>
                    <h6 class="mb-0 text-muted">Usuarios eliminados (papelera)</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-sm">
                        <thead class="text-uppercase small text-muted">
                            <tr>
                                <th>Usuario</th>
                                <th class="d-none d-md-table-cell">Email</th>
                                <th class="d-none d-md-table-cell">Eliminado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $usuariosEliminados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eliminado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="text-muted">
                                    <td>
                                        <div class="font-weight-semibold"><?php echo e($eliminado->name); ?></div>
                                        <div class="small">ID: <?php echo e($eliminado->id); ?></div>
                                    </td>
                                    <td class="d-none d-md-table-cell small"><?php echo e($eliminado->email); ?></td>
                                    <td class="d-none d-md-table-cell small">
                                        <?php echo e(optional($eliminado->deleted_at)->format('d/m/Y H:i')); ?>

                                    </td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-outline-success btn-sm"
                                            wire:click="$emit('generarRestaurarUsuarioSweetAlert', <?php echo e($eliminado->id); ?>, '<?php echo e(addslashes($eliminado->name)); ?>')">
                                            Restaurar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\buscar-usuario.blade.php ENDPATH**/ ?>