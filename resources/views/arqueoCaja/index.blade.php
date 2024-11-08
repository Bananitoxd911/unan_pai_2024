@extends('layouts.arqueo')

@section('contenido')

<p>Banco</p>
@if (isset($cuentas))
    @foreach ($cuentas as $cuenta )
        <p>Cuenta </p>
        <p>Numero Cuenta: {{$cuenta->numero_cuenta}}</p>
        <p>Total en de Saldo en cuenta: {{$cuenta->monto}}</p>
    @endforeach
@else 
    <a href="">Crear cuentas</a>
@endif



@endsection