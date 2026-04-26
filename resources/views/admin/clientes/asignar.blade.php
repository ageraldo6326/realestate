@extends('admin.layoutadmin')

@section('title', 'Asignar Contactos')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Contactos</a></li>
    <li class="breadcrumb-item active">Asignar</li>
@endsection

@section('page_title', 'Asignar Contactos')

@section('page_actions')
    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary btn-sm">
        Volver a contactos
    </a>
@endsection

@section('content')
    <style>
        .content-wrapper {
            background: linear-gradient(180deg, #f8fafc 0%, #eef4f7 100%);
        }

        .content {
            padding-top: .25rem;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-12">
            @livewire('asignar-contacto')
        </div>
    </div>

@endsection

@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
    $(document).ready(function () {
        // Aplicar máscara de dinero al campo de monto
        $('.monto').mask('000,000,000,000,000', { reverse: true });
    });
</script>
<script src="//unpkg.com/alpinejs" defer></script>
<script>




livewire.on('limpiarDescripcion', () => {  
    console.log('limpiarDescripcion');    
    editor.setData("");
});

window.livewire.on('editarDescripcion', valor => {  
    console.log('editarDescripcion');    
    editor.setData(valor);
});   

livewire.on('generarBorrarSweetAlert', (id, mensaje, metodo) => {

    Swal.fire({
        title: mensaje + id + '?',
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
            livewire.emit(metodo,id)
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })            

})
</script>
@endpush