@extends('admin.layoutadmin')

@section('title', 'Editar Zona')

@section('breadcrumb')
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item"><a href="{{ route('zonas.index') }}">Zonas</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('page_title', 'Editar Zona')

@section('content')
    @include('admin.zonas._form', [
        'mode' => 'edit',
        'zona' => $zona,
        'action' => route('zonas.update', $zona),
    ])
@endsection

