@extends('admin.layoutadmin')

@section('title', 'Tipos de Propiedad')

@section('breadcrumb')
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item active">Tipos de propiedad</li>
@endsection

@section('page_title', 'Tipos de Propiedad')

@section('content')
    <div class="container-fluid px-3">
        {{-- Mostrar mensajes de éxito del controlador --}}
        @if (session('success'))
            <div class="alert alert-success shadow-sm border-0 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger shadow-sm border-0 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @livewire('buscar-tipo-propiedad')
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('generarBorrarSweetAlert', (id) => {
                Swal.fire({
                    title: '¿Eliminar tipo de propiedad?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Eliminar',
                    cancelButtonColor: '#6c757d',
                    confirmButtonColor: '#dc3545',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('borrarTipoPropiedad', id);
                    }
                });
            });
        });
    </script>
@endpush
