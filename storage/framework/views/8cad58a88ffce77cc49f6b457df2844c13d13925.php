<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>DISPONIBLE PARA</h1>
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
                            <th>Disponible para</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $disponiblespara; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disponiblepara): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td scope="row"><?php echo e($disponiblepara->id); ?></td>
                            <td><?php echo e($disponiblepara->disponible_para); ?></td>

                            <td class="text-end">
                                <div class="div">
                                    <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-sm btn-block m-1 rounded" wire:click='edit(<?php echo e($disponiblepara->id); ?>)'
                                        data-toggle="modal" data-target="#modalForm">Editar</button>
                                    </div>
                                    <div class="col-md-6">
                                    <button type="button" class="btn btn-danger btn-sm btn-block m-1 rounded" wire:click='edit(<?php echo e($disponiblepara->id); ?>)'
                                        data-toggle="modal" data-target="#modalFormDelete">Eliminar</button>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
                    </tbody>
                </table>
                <?php echo e($disponiblespara->links('pagination::bootstrap-4')); ?>

            </div>
    
        </div>
    
    </div>

    <?php echo $__env->make('components.modalheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <div class="mb-3">
        <label for="" class="form-label">Disponible para</label>
        <input type="text" class="form-control" wire:model.lazy='disponible_para' placeholder="Disponible Para">
        <?php $__errorArgs = ['disponible_para'];
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
        <label for="" class="form-label">Disponible para</label>
        <input type="text" disabled class="form-control" wire:model.lazy='disponible_para' placeholder="Disponible para">
    </div>
    
    <?php echo $__env->make('components.modalfooterdelete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\disponible-para.blade.php ENDPATH**/ ?>