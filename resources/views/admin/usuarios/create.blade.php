@extends('admin.layoutadmin')

@section('title', 'Crear usuario')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
    <li class="breadcrumb-item active">Crear</li>
@endsection

@section('page_title', 'Crear usuario')

@section('content')
    @include('admin.usuarios._form', [
        'mode' => 'create',
        'action' => route('usuarios.store'),
    ])
@endsection
