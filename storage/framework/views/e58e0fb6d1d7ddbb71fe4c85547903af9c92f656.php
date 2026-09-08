

<?php $__env->startSection('title', 'Crear tarea'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('todo.index')); ?>">Tareas</a></li>
    <li class="breadcrumb-item active">Nueva tarea</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Crear tarea programada'); ?>

<?php $__env->startSection('page_actions'); ?>
    <a href="<?php echo e(route('todo.index')); ?>" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al listado
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-3">
        <div class="card border-0 shadow-sm overflow-hidden mb-3">
            <div class="card-body py-4" style="background: linear-gradient(135deg, #0f172a, #2563eb); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-uppercase small mb-2" style="letter-spacing:.14em; opacity:.75;">Planificación operativa</p>
                        <h2 class="h4 font-weight-bold mb-1">Registra una nueva tarea de seguimiento</h2>
                        <p class="mb-0" style="opacity:.85; max-width:44rem;">Define el tipo, responsable y fecha límite para mantener trazabilidad en la gestión de clientes.</p>
                    </div>
                    <span class="badge badge-light px-3 py-2">Formulario CRM</span>
                </div>
            </div>
        </div>

        <?php if(isset($errors) && $errors->any()): ?>
            <div class="alert alert-danger border-0 shadow-sm">
                <h3 class="h6 mb-2">Hay errores en el formulario</h3>
                <ul class="mb-0 pl-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12 col-xl-8 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="<?php echo e(route('todo.store')); ?>" method="post" enctype="multipart/form-data" novalidate>
                            <?php echo csrf_field(); ?>

                            <div class="form-group mb-3">
                                <label for="nombre" class="font-weight-600">Tarea</label>
                                <input
                                    type="text"
                                    class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="nombre"
                                    name="nombre"
                                    placeholder="Ej. Llamar cliente por actualización de propuesta"
                                    required
                                    value="<?php echo e(old('nombre')); ?>"
                                >
                                <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group mb-3">
                                <label for="descripcion" class="font-weight-600">Descripción</label>
                                <textarea
                                    class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="descripcion"
                                    name="descripcion"
                                    rows="4"
                                    placeholder="Describe el objetivo de la tarea y contexto necesario"
                                    required
                                ><?php echo e(old('descripcion')); ?></textarea>
                                <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="todo_tipo" class="font-weight-600">Tipo de tarea</label>
                                        <select class="form-control select2 form-control-sm <?php $__errorArgs = ['todo_tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="todo_tipo" id="todo_tipo" required>
                                            <option value="" disabled <?php echo e(old('todo_tipo') ? '' : 'selected'); ?>>Selecciona un tipo</option>
                                            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($tipo->id); ?>" <?php echo e(old('todo_tipo') == $tipo->id ? 'selected' : ''); ?>><?php echo e($tipo->todo_tipo); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['todo_tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="todo_estatus" class="font-weight-600">Estatus inicial</label>
                                        <select class="form-control select2 form-control-sm <?php $__errorArgs = ['todo_estatus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="todo_estatus" id="todo_estatus" required>
                                            <option value="" disabled <?php echo e(old('todo_estatus') ? '' : 'selected'); ?>>Selecciona un estatus</option>
                                            <?php $__currentLoopData = $estatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($estatus->id); ?>" <?php echo e(old('todo_estatus') == $estatus->id ? 'selected' : ''); ?>><?php echo e($estatus->todo_estatus); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['todo_estatus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="cliente_id" class="font-weight-600">Cliente</label>
                                        <select class="form-control select2 form-control-sm <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="cliente_id" id="cliente_id" required>
                                            <option value="0" <?php echo e(old('cliente_id', '0') == '0' ? 'selected' : ''); ?>>Empresa</option>
                                            <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($cliente->id); ?>" <?php echo e(old('cliente_id') == $cliente->id ? 'selected' : ''); ?>><?php echo e($cliente->nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="fechaLimite" class="font-weight-600">Fecha límite</label>
                                        <input
                                            type="datetime-local"
                                            class="form-control <?php $__errorArgs = ['fechaLimite'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="fechaLimite"
                                            name="fechaLimite"
                                            required
                                            value="<?php echo e(old('fechaLimite')); ?>"
                                        >
                                        <?php $__errorArgs = ['fechaLimite'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-1"></i> Guardar tarea
                                </button>
                                <a href="<?php echo e(route('todo.index')); ?>" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h3 class="h6 text-uppercase text-muted mb-3">Recomendaciones</h3>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="font-weight-600">Sé específico en el nombre</div>
                            <p class="text-muted small mb-0">Un título claro acelera la priorización y evita tareas duplicadas.</p>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="font-weight-600">Define el estatus correcto</div>
                            <p class="text-muted small mb-0">Comienza en pendiente para facilitar seguimiento y reportes.</p>
                        </div>
                        <div>
                            <div class="font-weight-600">Asocia un cliente cuando aplique</div>
                            <p class="text-muted small mb-0">Te ayudará a mantener historial completo dentro del CRM.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\todos\create.blade.php ENDPATH**/ ?>