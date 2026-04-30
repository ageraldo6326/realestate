@extends('admin.layoutadmin')

@section('title', 'Editar testimonio')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item"><a href="{{ route('testimonios.index') }}">Testimonios</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('page_title', 'Editar testimonio')

@section('content')
    @include('admin.testimonios._form', [
        'mode' => 'edit',
        'action' => route('testimonios.update', $testimonio),
        'testimonio' => $testimonio,
    ])
@endsection

