@extends('admin.layoutadmin')

@section('title', 'Ventas')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">CRM</a></li>
    <li class="breadcrumb-item active">Ventas</li>
@endsection

@section('page_title', 'Registro de ventas')

@section('content')
    <div class="container-fluid px-3">
        <div class="card border-0 shadow-sm overflow-hidden mb-3">
            <div class="card-body py-4" style="background: linear-gradient(135deg, #1f2937, #0f766e); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-uppercase small mb-2" style="letter-spacing:.14em; opacity:.75;">Cierres y seguimiento</p>
                        <h2 class="h4 font-weight-bold mb-1">Monitorea ventas cerradas y operaciones en curso</h2>
                        <p class="mb-0" style="opacity:.82; max-width:42rem;">Consulta rápidamente asesores, propiedades, compradores y fechas de cierre desde una sola pantalla.</p>
                    </div>
                    <a href="{{ route('crearventa') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus mr-1"></i> Registrar venta
                    </a>
                </div>
            </div>
        </div>

        @livewire('registrar-ventas')
    </div>
@endsection