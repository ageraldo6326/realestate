@extends('admin.layoutadmin')

@section('title', 'Inventario')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('propiedades.index') }}">Propiedades</a></li>
    <li class="breadcrumb-item active">Inventario</li>
@endsection

@section('page_title', 'Inventario disponible')

@section('content')
    @php
        $isAdmin = auth()->check() && auth()->user()->hasAnyRole(['admin', 'superadmin']);
    @endphp
    <div class="container-fluid px-3">
        <div class="card border-0 shadow-sm overflow-hidden mb-3">
            <div class="card-body py-4" style="background: linear-gradient(135deg, #0f172a, #1d4ed8); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-uppercase small mb-2" style="letter-spacing:.14em; opacity:.75;">Portafolio comercial</p>
                        <h2 class="h4 font-weight-bold mb-1">Consulta rápida del inventario activo</h2>
                        <p class="mb-0" style="opacity:.82; max-width:42rem;">Filtra por referencia, zona, moneda y rango de precio para ubicar propiedades activas sin salir del CRM.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('propiedades.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-building mr-1"></i> Mis propiedades
                        </a>
                        @if ($isAdmin)
                            <a href="{{ route('asignar') }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-user-check mr-1"></i> Asignar contacto
                            </a>
                            <a href="{{ route('import.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-file-import mr-1"></i> Importar contactos
                            </a>
                        @endif
                        <a href="{{ route('propiedades.create') }}" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-plus mr-1"></i> Nueva propiedad
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @livewire('mostrar-inventario')
    </div>
@endsection



