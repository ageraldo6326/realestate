@extends('admin.layoutadmin')

@section('title', 'Registrar Venta')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('registrarventa') }}">Ventas</a></li>
    <li class="breadcrumb-item active">Registrar Venta</li>
@endsection

@section('page_title', 'Registrar Venta')

@section('content')
    <div class="container-fluid px-3">

        <div class="card border-0 shadow-sm mb-3 overflow-hidden">
            <div class="card-body py-3" style="background: linear-gradient(120deg, #0f172a, #1e3a8a); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <h2 class="h4 mb-1 font-weight-bold">Registrar nueva venta</h2>
                        <p class="mb-0" style="opacity:.85;">Vincula una propiedad con vendedor, comprador y asesor para
                            cerrar el negocio.</p>
                    </div>
                    <div class="d-flex align-items-center" style="opacity:.9;">
                        <i class="fas fa-handshake mr-2"></i>
                        <span>CRM · Ventas</span>
                    </div>
                </div>
            </div>
        </div>

        @livewire('crear-ventas')

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('ventaGrabada', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Venta registrada',
                    timer: 1800,
                    showConfirmButton: false
                });
            });
        });
    </script>
@endpush
