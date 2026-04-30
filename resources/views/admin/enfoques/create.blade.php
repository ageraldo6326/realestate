@extends('admin.layoutadmin')

@section('title', 'Nuevo enfoque')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item"><a href="{{ route('enfoques.index') }}">Enfoques</a></li>
    <li class="breadcrumb-item active">Crear</li>
@endsection

@section('page_title', 'Nuevo enfoque')

@section('content')
    @include('admin.enfoques._form', [
        'mode' => 'create',
        'action' => route('enfoques.store'),
    ])
@endsection