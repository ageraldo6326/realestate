@extends('admin.layoutadmin')

@section('title', 'Crear Tipo de Propiedad')

@section('breadcrumb')
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item"><a href="{{ route('tipopropiedades.index') }}">Tipos de propiedad</a></li>
    <li class="breadcrumb-item active">Crear</li>
@endsection

@section('page_title', 'Crear Tipo de Propiedad')

@section('content')
    @include('admin.tipopropiedades._form', [
        'mode' => 'create',
        'tipopropiedad' => null,
        'action' => route('tipopropiedades.store'),
    ])
@endsection
