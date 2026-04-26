@extends('admin.layoutadmincalender')

@section('content')
ddd
@endsection


@section('eventos')

@foreach ($tareas as $tarea)

{
    title : '{{ $tarea->nombre }}',
    start : new Date({{ substr($tarea->fechaLimite,0,4) }}, {{ substr($tarea->fechaLimite,5,2)-1 }} , {{ substr($tarea->fechaLimite,8,2) }}, {{ substr($tarea->fechaLimite,11,2) }}, {{ substr($tarea->fechaLimite,14,2) }}),
    allDay : false,
    url : '/admin/todo/{{ $tarea->id}}/edit',
    backgroundColor: '{{$tarea->color}}',
    borderColor : '{{$tarea->color}}'   
},
    
@endforeach


@endsection
