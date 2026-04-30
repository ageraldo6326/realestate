@extends('admin.layoutadmin')

@section('title', 'Editar Tipo de Tarea')

@section('breadcrumb')
    <li class="breadcrumb-item">Catalogos</li>
    <li class="breadcrumb-item"><a href="{{ route('tipostareas.index') }}">Tipos de tarea</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('page_title', 'Editar Tipo de Tarea')

@section('content')
    @include('admin.tipotarea._form', [
        'mode' => 'edit',
        'tipotarea' => $tipotarea,
        'action' => route('tipostareas.update', $tipotarea->id),
    ])

@endsection