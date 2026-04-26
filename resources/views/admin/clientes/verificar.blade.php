@extends('admin.layoutadmin')

@section('title', 'Revision de Contactos')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Contactos</a></li>
    <li class="breadcrumb-item active">Revision</li>
@endsection

@section('page_title', 'Revision de Contactos')

@section('content')
    <div class="container-fluid px-3">
        <div class="card border-0 shadow-sm mb-3 overflow-hidden">
            <div class="card-body py-3" style="background: linear-gradient(120deg, #052e16, #166534); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <h2 class="h4 mb-1 font-weight-bold">Verificacion de Contactos</h2>
                        <p class="mb-0" style="opacity: .85;">Busca por telefono o correo para evitar duplicados y verificar asignacion.</p>
                    </div>
                    <div class="d-flex align-items-center" style="opacity: .9;">
                        <i class="fas fa-search mr-2"></i>
                        <span>Control de calidad CRM</span>
                    </div>
                </div>
            </div>
        </div>

        @livewire('consultar-cliente')
    </div>
@endsection


