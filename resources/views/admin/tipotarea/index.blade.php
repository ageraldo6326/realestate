@extends('admin.layoutadmin')

@section('title', 'Tipos de Tarea')

@section('breadcrumb')
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item active">Tipos de tarea</li>
@endsection

@section('page_title', 'Tipos de Tarea')

@section('content')
    <div class="container-fluid px-3">
        @if (session('status'))
            <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-3">
                {{ session('error') }}
            </div>
        @endif

        @livewire('tipo-tareas')
    </div>
@endsection

@push('scripts')
    <script>
        livewire.on('generarBorrarTipoTareaSweetAlert', (id, nombre) => {
            Swal.fire({
                title: 'Confirmar eliminacion',
                text: nombre ? `Se eliminara el tipo de tarea "${nombre}".` : 'Se eliminara el tipo de tarea seleccionado.',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Eliminar',
                cancelButtonColor: '#6c757d',
                confirmButtonColor: '#dc3545',
            }).then((result) => {
                if (result.isConfirmed) {
                    livewire.emit('borrarTipoTarea', id);
                }
            });
        });
    </script>
@endpush


