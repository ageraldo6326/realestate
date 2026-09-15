@extends('admin.layoutadmin')

@section('title', 'Configuración del sitio público')

@section('breadcrumb')
    <li class="breadcrumb-item">Configuración</li>
    <li class="breadcrumb-item active">Configuración del sitio público</li>
@endsection

@section('page_title', 'Configuración del sitio público')

@section('content')
    @include('admin.empresa._form', [
        'mode' => 'edit',
        'inmobiliaria' => $inmobiliaria,
        'action' => route('inmobiliaria.update', $inmobiliaria->id),
    ])
@endsection
