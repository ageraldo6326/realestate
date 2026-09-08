<div>
    

    <form method="GET" action="<?php echo e(route('propiedades.index')); ?>">
        <?php echo csrf_field(); ?>
        <div class="input-group my-3">
            <input type="text" class="form-control" wire:model='criterio' name="criterio"
                placeholder="Buscar por ID, titulo, ciudad, provincia, sector o barrio">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" name="buscar" value="buscar">Buscar</button>
            </div>
        </div>
    </form>


    <div class="row">

        <div class="col-12 ">

            <table class="table mt-0 rounded border table-hover">

                <div class="col-12 shadow-lg mb-1 bg-white">

                    <thead class="bg-info">
                        <tr class="border-0 text-white font-weight-bold rounded-circle">
                            <th>#</th>
                            <th class="text-left">Foto</th>
                            <th>Titulo</th>
                            <th class="d-none d-md-table-cell">Ubicación</th>
                            <th class="d-none d-md-table-cell">Clicks</th>
                            <th class="d-none d-md-table-cell">Creada</th>
                            <th class="col-1 text-start">Action</th>
                        </tr>
                    </thead>

                </div>

                <tbody>

                    <?php $__currentLoopData = $propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <th scope="row"><?php echo e($propiedad->id); ?></th>
                            <td><img src="<?php echo e($propiedad->foto_portada); ?>" class="img-thumbnail " height="50rem"
                                    width="100rem" alt=""></td>
                            <td><?php echo e($propiedad->titulo); ?></td>
                            <td class="d-none d-md-table-cell">
                                <?php echo e($propiedad->ciudad ?: 'Santo Domingo'); ?>, <?php echo e($propiedad->provincia_nombre); ?>

                                <?php if($propiedad->barrio_nombre || $propiedad->sector_nombre): ?>
                                    - <?php echo e($propiedad->barrio_nombre ?: $propiedad->sector_nombre); ?>

                                <?php endif; ?>
                            </td>
                            <td class="d-none d-md-table-cell"><?php echo e($propiedad->clicks); ?></td>
                            <td class="d-none d-md-table-cell"><?php echo e($propiedad->created_at); ?></td>
                            <td>
                                <div class="row">
                                    <div class="col-md-8">
                                        <form method="GET"
                                            action="<?php echo e(route('editarpendientescualquiera', $propiedad->id)); ?>">
                                            
                                            <button type="submit"
                                                class="btn btn-primary btn-sm btn-block m-1 float-right">Editar</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-2">
                    <?php echo e($propiedades->links('pagination::bootstrap-4')); ?>

                </div>
            </div>
        </div>


    </div>

</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\mostrar-propiedades.blade.php ENDPATH**/ ?>