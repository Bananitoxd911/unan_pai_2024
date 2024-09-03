@extends('layouts.nomina')


@section('contenido')
    <a href="{{route('empleados.index', ['empresa_id' => $empresa->id])}}">Empleados</a>
    <a href="#">Nomina</a>
@endsection