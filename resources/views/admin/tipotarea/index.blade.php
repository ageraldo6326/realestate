@extends('admin.layoutadmin')

@section('title', 'Tipos de Tarea')

@section('breadcrumb')
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item active">Tipos de tarea</li>
@endsection

@section('page_title', 'Tipos de Tarea')

@section('content')
    <div class="container-fluid px-3">
        @livewire('tipo-tareas')
    </div>
@endsection


