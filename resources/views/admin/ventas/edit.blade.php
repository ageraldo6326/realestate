@extends('admin.layoutadmin')

@section('content')
    @livewire('editar-venta',['Id' => $id])
@endsection