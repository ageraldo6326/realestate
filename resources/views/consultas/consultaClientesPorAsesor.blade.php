@extends('admin.layoutadmin')

@section('title', 'Clientes por asesor')

@section('breadcrumb')
    <li class="breadcrumb-item active">Clientes por asesor</li>
@endsection

@section('page_title', 'Clientes por asesor')

@section('content')
    <div class="container-fluid py-3 py-md-4">
        @livewire('clientes-asesor-consulta')
    </div>
@endsection
