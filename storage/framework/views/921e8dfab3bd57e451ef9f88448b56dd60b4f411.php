<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>ZONAS 1</h1>
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
                            <th>Zona</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td scope="row"><?php echo e($zona->id); ?></td>
                            <td><?php echo e($zona->zona); ?></td>
                            <td class="text-center">
                                <div class="justify-content-end">
                                        <button type="button" class="btn btn-primary btn-sm btn-block m-1 rounded" wire:click='edit(<?php echo e($zona->id); ?>)' data-toggle="modal" data-target="#modalForm">Editar</button>
                                        <button type="button" class="btn btn-danger btn-sm btn-block m-1 rounded" wire:click='edit(<?php echo e($zona->id); ?>)' data-toggle="modal" data-target="#modalFormDelete">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>
                <?php echo e($zonas->links('pagination::bootstrap-4')); ?>

            </div>

        </div>
        

    </div>



    <?php echo $__env->make('components.modalheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="mb-3">
        <label for="" class="form-label">Zona</label>
        <input type="text" class="form-control" wire:model.lazy='zonaName' aria-describedby="helpId" placeholder="zona">
        <?php $__errorArgs = ['zonaName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    
    <?php echo $__env->make('components.modalfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('components.modalheaderdelete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <div class="mb-3">
        <label for="" class="form-label">Zona</label>
        <input type="text" disabled class="form-control" wire:model.lazy='zonaName' aria-describedby="helpId" placeholder="zona">
    </div>
    
    <?php echo $__env->make('components.modalfooterdelete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>    

</div><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\zonas.blade.php ENDPATH**/ ?>