@extends('admin.layoutadmin')

@section('title', 'Estados')

@section('breadcrumb')
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item active">Estados</li>
@endsection

@section('page_title', 'Estados')

@section('content')
    <div class="container-fluid px-3">
        @livewire('buscar-estado')
    </div>
@endsection

@push('scripts')
    <script>
        livewire.on('generarBorrarEstadoSweetAlert', id => {
            Swal.fire({
                title: '¿Borrar el estado ' + id + '?',
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
                    livewire.emit('borrarEstado', id);
                }
            });
        });
    </script>
@endpush


