<div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>ESTADOS</h1>
                <div class="m-3 col-12 text-end">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalForm">Nuevo</button>
                </div>
                <div class="input-group my-3">
                    <input type="text" class="form-control" wire:model='criterio' name="criterio" placeholder="Buscar...">
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>N</th>
                            <th>Estado</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td scope="row"><?php echo e($estado->id); ?></td>
                            <td><?php echo e($estado->estado); ?></td>
                            <td class="text-end">
                                <div class="row">
                                    <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-sm btn-block m-1 rounded" wire:click='edit(<?php echo e($estado->id); ?>)'
                                        data-toggle="modal" data-target="#modalForm">Editar</button>
                                    </div>
                                    <div class="col-md-6">
                                    <button type="button" class="btn btn-danger btn-sm btn-block m-1 rounded" wire:click='edit(<?php echo e($estado->id); ?>)'
                                        data-toggle="modal" data-target="#modalFormDelete">Eliminar</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
                    </tbody>
                </table>
                <?php echo e($estados->links('pagination::bootstrap-4')); ?>

            </div>
    
        </div>
    
    </div>
    <?php echo $__env->make('components.modalheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="mb-3">
        <label for="" class="form-label">Estado</label>
        <input type="text" class="form-control" wire:model.lazy='estado' placeholder="Estado">
        <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger">*<?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <?php echo $__env->make('components.modalfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('components.modalheaderdelete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="mb-3">
        <label for="" class="form-label">Estado</label>
        <input type="text" disabled class="form-control" wire:model.lazy='estado' placeholder="Estadp">
    </div>

    <?php echo $__env->make('components.modalfooterdelete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\estados.blade.php ENDPATH**/ ?>