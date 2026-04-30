@extends('admin.layoutadmin')

@section('title', 'Nuevo Tipo de Tarea')

@section('breadcrumb')
    <li class="breadcrumb-item">Catalogos</li>
    <li class="breadcrumb-item"><a href="{{ route('tipostareas.index') }}">Tipos de tarea</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('page_title', 'Nuevo Tipo de Tarea')

@section('content')
    @include('admin.tipotarea._form', [
        'mode' => 'create',
        'tipotarea' => null,
        'action' => route('tipostareas.store'),
    ])

@endsection