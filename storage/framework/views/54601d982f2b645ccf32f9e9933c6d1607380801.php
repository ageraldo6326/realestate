


<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>CLIENTES</h1>
            <table class="table table-striped">
                <thead class="bg-primary text-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Precio Min</th>
                        <th scope="col">Precio Max</th>
                        <th scope="col">Fec de Contacto</th>
                        <th scope="col">Creado</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td scope="row"><?php echo e($cliente->id); ?></td>
                        <td><?php echo e($cliente->nombre); ?></td>
                        <td class="text-truncate"><?php echo e($cliente->telefono); ?></td>
                        <td><?php echo e($cliente->email); ?></td>
                        <td><?php echo e(number_format($cliente->precio_mini)); ?></td>
                        <td><?php echo e(number_format($cliente->precio_max)); ?></td>
                        <td><?php echo e($cliente->contact_at); ?></td>
                        <td><?php echo e($cliente->created_at); ?></td>
                        <td class="text-center">
                            <a href="/consulta/vercliente/<?php echo e($cliente->id); ?>">
                                <i class="fa fa-glasses"></i>
                            </a>
                        </td>                        
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/consultas/consultaClientesPorAsesorDetalle.blade.php ENDPATH**/ ?>