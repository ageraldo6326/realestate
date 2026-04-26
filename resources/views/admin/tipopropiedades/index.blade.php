@extends('admin.layoutadmin')

@section('title', 'Tipos de Propiedad')

@section('breadcrumb')
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item active">Tipos de propiedad</li>
@endsection

@section('page_title', 'Tipos de Propiedad')

@section('content')
    <div class="container-fluid px-3">
        @livewire('buscar-tipo-propiedad')
    </div>
@endsection

@push('scripts')
    <script>
        livewire.on('generarBorrarTipoPropiedadSweetAlert', id => {
            Swal.fire({
                title: '¿Borrar el tipo de propiedad ' + id + '?',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Borrar',
                cancelButtonColor: '#6c757d',
                confirmButtonColor: '#dc3545',
                icon: 'warning',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registro eliminado',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    livewire.emit('borrarTipoPropiedad', id);
                }
            });
        });
    </script>
@endpush


