@extends('admin.layoutadmin')

@section('title', 'Propiedades')

@section('breadcrumb')
    <li class="breadcrumb-item active">Mis propiedades</li>
@endsection

@section('page_title', 'Mis propiedades')

@section('content')

    <div class="container-fluid px-3">
        @livewire('buscar-propiedad')
    </div>

@endsection

@push('scripts')
    <script>
        livewire.on('generarBorrarPropiedadSweetAlert', id => {
            Swal.fire({
                title: '¿Borrar la propiedad ' + id + '?',
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
                    livewire.emit('borrarPropiedad', id);
                }
            });
        });
    </script>
@endpush
