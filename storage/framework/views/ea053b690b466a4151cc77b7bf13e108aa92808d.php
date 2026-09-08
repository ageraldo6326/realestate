<div>

    <div>
        <form class="btn-group" wire:ignore.self>
            <label for="" class="text-lg mx-2">Inicio</label>
            <input type="date" class="form-control" wire:model.lazy='fecha_ini' required>
            <label for="" class="mx-2 text-lg">Fin</label>
            <input type="date" class="form-control" wire:model.lazy='fecha_fin' required> 
        </form>
    </div>
    <div class="col-8">

        <table class="table mt-2 table-bordered">
            <thead class="bg-primary">
                <tr>
                    <th class="w-75">Asesor(a)</th>
                    <th class="w-25">Cant Clientes</th>
                    <th class="w-25">Ver Clientes</th>
                </tr>
            </thead>
            <tbody>
                
                    <?php if($fecha_ini!=null and $fecha_fin!=null): ?>
                        <?php $__currentLoopData = $clientes_por_asesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clientes_por_asesor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-left"><?php echo e($clientes_por_asesor->name); ?></td>
                            <td class="text-left"><?php echo e($clientes_por_asesor->total); ?></td>
                            <td class="text-center">
                                <a href="/consulta/verclientesporasesor/<?php echo e($clientes_por_asesor->userid); ?>/<?php echo e($fecha_ini); ?>/<?php echo e($fecha_fin); ?>">
                                    <i class="fa fa-glasses"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
 
            </tbody>
        </table>
        
    </div>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\clientes-asesor-consulta.blade.php ENDPATH**/ ?>