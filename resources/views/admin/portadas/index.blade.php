@extends('admin.layoutadmin')

@section('title', 'Portadas')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item active">Portadas</li>
@endsection

@section('page_title', 'Portadas')

@section('content')
    <div class="container-fluid px-3">
        @livewire('buscar-portada')
    </div>
@endsection

@push('scripts')
    <script>
        livewire.on('generarBorrarPortadaSweetAlert', id => {
            Swal.fire({
                title: '¿Borrar la portada ' + id + '?',
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
                    livewire.emit('borrarPortada', id);
                }
            });
        });
    </script>
@endpush