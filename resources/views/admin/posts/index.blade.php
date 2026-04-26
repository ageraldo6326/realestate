@extends('admin.layoutadmin')

@section('title', 'Posts')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item active">Posts</li>
@endsection

@section('page_title', 'Blog / Posts')

@section('content')
    <div class="container-fluid px-3">
        @livewire('buscar-post')
    </div>
@endsection

@push('scripts')
    <script>
        livewire.on('generarBorrarPostSweetAlert', id => {
            Swal.fire({
                title: '¿Borrar el post ' + id + '?',
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
                    livewire.emit('borrarPost', id);
                }
            });
        });
    </script>
@endpush



