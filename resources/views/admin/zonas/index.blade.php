@extends('admin.layoutadmin')

@section('title', 'Zonas')

@section('breadcrumb')
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item active">Zonas</li>
@endsection

@section('page_title', 'Zonas')

@section('content')
    <div class="container-fluid px-3">
        @livewire('buscar-zona')
    </div>
@endsection

@push('scripts')
    <script>
        livewire.on('generarBorrarZonaSweetAlert', id => {
            Swal.fire({
                title: '¿Borrar la zona ' + id + '?',
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
                    livewire.emit('borrarZona', id);
                }
            });
        });
    </script>
@endpush