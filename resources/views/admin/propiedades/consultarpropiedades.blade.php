@extends('admin.layoutadmin')

@section('title', 'Todas las propiedades')

@section('breadcrumb')
    <li class="breadcrumb-item active">Todas las propiedades</li>
@endsection

@section('page_title', 'Todas las propiedades')

@section('content')
    <div class="container-fluid py-3 py-md-4">
        @livewire('mostrar-propiedades')
    </div>


@endsection
