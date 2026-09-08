

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Dashboard</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1>Post</h1>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
.zoom {
    padding: 0px;
    transition: transform .2s;
    margin: 0 auto;
  }
  
  .zoom:hover {
    transform: scale(2); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
  }
  </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>


<script src="//unpkg.com/alpinejs" defer></script>
<script>

livewire.on('limpiarContenido', () => {  
    console.log('limpiarContenido');    
    editor.setData("");
});

window.livewire.on('editarContenido', valor => {  
    console.log('editarContenido');    
    editor.setData(valor);
});   
       
livewire.on('generarBorrarPostSweetAlert', id => {

Swal.fire({
    title: 'Realmente desea borrar este Post ' + id + '?',
    showCancelButton: true,
    cancelButtonText: `Cancelar`,
    confirmButtonText: 'Borrar',
    cancelButtonColor: "#3085d6",
    confirmButtonColor: "#d33",
    icon: 'warning',
    }).then((result) => {
    if (result.value==true) {
        Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Registro Eliminado",
        showConfirmButton: false,
        timer: 1500
        });                
        livewire.emit("borrarPost",id)
    } else if (result.isDenied) {
        Swal.fire('Changes are not saved', '', 'info')
    }
})            

})




</script>


<?php $__env->stopSection(); ?>




<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\todos\nuevacalendario.blade.php ENDPATH**/ ?>