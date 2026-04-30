@extends('admin.layoutadmin')

@section('title', 'Empresa')

@section('breadcrumb')
    <li class="breadcrumb-item">Configuración</li>
    <li class="breadcrumb-item active">Empresa</li>
@endsection

@section('page_title', 'Empresa')

@section('content')
    @include('admin.empresa._form', [
        'mode' => 'create',
        'inmobiliaria' => null,
        'action' => route('inmobiliaria.store'),
    ])
@endsection
