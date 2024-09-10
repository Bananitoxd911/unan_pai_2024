@extends('layouts.nomina')

@section('contenido')
    <div class="container">
        <h1>Detalles de Nómina</h1>
        <h2>Nómina: {{ $nomina->id }}</h2>
        <p>Empresa: {{ $nomina->empresa->nombre }}</p>
        <p>Fecha: {{ $nomina->fecha }}</p>
        <p>Total: {{ number_format($nomina->total, 2) }}</p>
        
        <h3>Detalles</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empleado</th>
                    <th>Salario Bruto</th>
                    <th>Horas Extra</th>
                    <th>INSS Patronal</th>
                    <th>Vacaciones</th>
                    <th>13° Mes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nomina->detalleNomina as $detalle)
                    <tr>
                        <td>{{ $detalle->id }}</td>
                        <td>{{ $detalle->empleado->nombre_completo }}</td>
                        <td>{{ number_format($detalle->salario_bruto, 2) }}</td>
                        <td>{{ $detalle->cantidad_hrs_extra }}</td>
                        <td>{{ number_format($detalle->inss_patronal, 2) }}</td>
                        <td>{{ number_format($detalle->vacaciones, 2) }}</td>
                        <td>{{ number_format($detalle->treceavo_mes, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
