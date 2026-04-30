@extends('admin.layoutadmin')

@section('title', 'Editar Tipo de Propiedad')

@section('breadcrumb')
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item"><a href="{{ route('tipopropiedades.index') }}">Tipos de propiedad</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('page_title', 'Editar Tipo de Propiedad')

@section('content')
    @include('admin.tipopropiedades._form', [
        'mode' => 'edit',
        'tipopropiedad' => $tipopropiedad,
        'action' => route('tipopropiedades.update', $tipopropiedad->id),
    ])
@endsection
