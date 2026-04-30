@extends('admin.layoutadmin')

@section('title', 'Nueva Zona')

@section('breadcrumb')
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item"><a href="{{ route('zonas.index') }}">Zonas</a></li>
    <li class="breadcrumb-item active">Nueva</li>
@endsection

@section('page_title', 'Nueva Zona')

@section('content')
    @include('admin.zonas._form', [
        'mode' => 'create',
        'zona' => null,
        'action' => route('zonas.store'),
    ])
@endsection

