

<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Editar Tarea</h1>
            <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
            <?php endif; ?>
            <form action="<?php echo e(route("todo.update",$tarea->id)); ?>" method="post" enctype="multipart/form-data">
                <?php echo method_field("put"); ?>
                <?php echo csrf_field(); ?>
                <div class="form-group">

                    <div class="form-group">
                        <label for="nombre">Tarea</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="tarea" required
                            value="<?php echo e($tarea->nombre); ?>">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required
                            rows="3"><?php echo e($tarea->descripcion); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="Clientes">Tipo de Tarea</label>
                        <select class="form-control select2 form-control-sm" name="todo_tipo" id="todo_tipo">
                            <option selected>Tipo</option>
                            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php if($tarea->todo_tipo==$tipo->id): ?> selected <?php endif; ?> value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->todo_tipo); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="datetime-local" class="form-control" id="fechaLimite" name="fechaLimite"
                            placeholder="Fecha Limite" required value="<?php echo e($tarea->fechaLimite); ?>">
                    </div>

                    <div class="form-group">
                        <label for="Clientes">Cliente</label>
                        <select class="form-control select2 form-control-sm"" name="cliente_id" id="cliente_id">
                            <option selected>Cliente</option>
                            <option value="0" selected>Empresa</option>
                            <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php if($tarea->cliente_id==$cliente->id): ?> selected <?php endif; ?> value="<?php echo e($cliente->id); ?>"><?php echo e($cliente->nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>
                    </div>


                    <div class="form-group">
                        <label for="Clientes">Estatus de la Tarea</label>
                        <select class="form-control select2 form-control-sm"" name="todo_estatus" id="todo_estatus">
                            <option selected>Estatus</option>
                            <?php $__currentLoopData = $estatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php if($tarea->todo_estatus==$estatus->id): ?> selected <?php endif; ?> value="<?php echo e($estatus->id); ?>"><?php echo e($estatus->todo_estatus); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-success" name="submit" id="submit" value="Grabar">
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\todos\edit.blade.php ENDPATH**/ ?>