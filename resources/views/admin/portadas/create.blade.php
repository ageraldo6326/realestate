@extends('admin.layoutadmin')

@section('title', 'Nueva portada')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item"><a href="{{ route('portadas.index') }}">Portadas</a></li>
    <li class="breadcrumb-item active">Crear</li>
@endsection

@section('page_title', 'Nueva portada')

@section('content')
    @include('admin.portadas._form', [
        'mode' => 'create',
        'action' => route('portadas.store'),
    ])
@endsection