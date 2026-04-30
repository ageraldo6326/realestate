@extends('admin.layoutadmin')

@section('title', 'Editar portada')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item"><a href="{{ route('portadas.index') }}">Portadas</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('page_title', 'Editar portada')

@section('content')
    @include('admin.portadas._form', [
        'mode' => 'edit',
        'action' => route('portadas.update', $portada),
        'portada' => $portada,
    ])
@endsection