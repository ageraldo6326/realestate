@extends('admin.layoutadmin')

@section('title', 'Usuarios')

@section('breadcrumb')
    <li class="breadcrumb-item">Configuración</li>
    <li class="breadcrumb-item active">Usuarios</li>
@endsection

@section('page_title', 'Usuarios')

@section('content')

    <div class="container-fluid px-3">
        @livewire('buscar-usuario')
    </div>

@endsection

@push('scripts')
    <script>
        livewire.on('generarBorrarUsuarioSweetAlert', id => {
            Swal.fire({
                title: '¿Borrar el usuario ' + id + '?',
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
                    livewire.emit('borrarUsuario', id);
                }
            });
        });

        livewire.on('generarRestaurarUsuarioSweetAlert', (id, nombre) => {
            Swal.fire({
                title: '¿Restaurar a ' + nombre + '?',
                text: 'El usuario volverá a estar activo en el sistema.',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Restaurar',
                cancelButtonColor: '#6c757d',
                confirmButtonColor: '#28a745',
                icon: 'question',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Usuario restaurado',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    livewire.emit('restaurarUsuario', id);
                }
            });
        });
    </script>
@endpush
