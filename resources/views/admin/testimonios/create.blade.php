@extends('admin.layoutadmin')

@section('title', 'Nuevo testimonio')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item"><a href="{{ route('testimonios.index') }}">Testimonios</a></li>
    <li class="breadcrumb-item active">Crear</li>
@endsection

@section('page_title', 'Nuevo testimonio')

@section('content')
    @include('admin.testimonios._form', [
        'mode' => 'create',
        'action' => route('testimonios.store'),
    ])
@endsection

