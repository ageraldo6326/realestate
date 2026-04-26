@extends('admin.layoutadmin')

@section('title', 'Enfoques')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item active">Enfoques</li>
@endsection

@section('page_title', 'Enfoques')

@section('content')
    <div class="container-fluid px-3">
        @livewire('buscar-enfoque')
    </div>
@endsection

@push('scripts')
    <script>
        livewire.on('generarBorrarEnfoqueSweetAlert', id => {
            Swal.fire({
                title: '¿Borrar el enfoque ' + id + '?',
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
                    livewire.emit('borrarEnfoque', id);
                }
            });
        });
    </script>
@endpush



