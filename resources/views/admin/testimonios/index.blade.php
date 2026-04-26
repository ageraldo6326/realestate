@extends('admin.layoutadmin')

@section('title', 'Testimonios')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item active">Testimonios</li>
@endsection

@section('page_title', 'Testimonios')

@section('content')
    <div class="container-fluid px-3">
        @livewire('buscar-testimonio')
    </div>
@endsection

@push('scripts')
    <script>
        livewire.on('generarBorrarTestimonioSweetAlert', id => {
            Swal.fire({
                title: '¿Borrar el testimonio ' + id + '?',
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
                    livewire.emit('borrarTestimonio', id);
                }
            });
        });
    </script>
@endpush