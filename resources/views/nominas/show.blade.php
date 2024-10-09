@extends('layouts.nomina')

@section('contenido')
<style>
    @media print {
        .tabla-mostrar {
            position: absolute;
            left: 0;
            font-size: 0.4rem; /* Reduce el tamaño de la fuente */
        }

        table {
            width: 100%; /* Asegura que la tabla ocupe el ancho completo */
            font-size: 0.4rem; /* Reduce el tamaño de la fuente en la tabla */
            border-collapse: collapse; /* Elimina los espacios entre las celdas */
        }

        th, td {
            padding: 5px; /* Elimina el padding de las celdas */
            margin: 0; /* Elimina los márgenes de las celdas */
            text-align: center;
        }

        button{
            visibility: hidden;
        }
    }
</style>
<div class="tabla-mostrar">
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center mb-5">
            <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo de {{ $empresa->nombre }}" class="h-12 w-12 mr-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $empresa->nombre }}</h2>
        </div>

        <h1 class="text-2xl font-bold mb-4">Nómina - {{ $nomina->fecha }}</h1>
        <h2 class="text-xl mb-4">Total: C$ {{ number_format($nomina->total, 2) }}</h2>
        <h3 class="text-lg font-semibold mb-2">Detalles de la Nómina</h3>
        
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase leading-normal">
                    <th>ID Empleado</th>
                    <th>Nombre Completo</th>
                    <th>Cargo</th>
                    <th>Salario Bruto</th>
                    <th>Horas Extras</th>
                    <th>monto extras</th>
                    <th>Antigüedad (Años)</th>
                    <th>Antigüedad %</th>
                    <th>Antigüedad</th>
                    <th>Total Ingresos</th>
                    <th>INSS Laboral</th>
                    <th>IR</th>
                    <th>Total Deducciones</th>
                    <th>Neto a Recibir</th>
                    <th>INSS Patronal</th>
                    <th>INATEC</th>
                    <th>Vacaciones</th>
                    <th>13° Mes</th>
                </tr>
            </thead>
            <tbody class="text-gray-600  font-light">
                @foreach($nomina->detalleNomina as $detalle)
                @php
                    $nombre_completo = $detalle->empleado->primer_nombre .' '. $detalle->empleado->segundo_nombre .' '. $detalle->empleado->primer_apellido .' '. $detalle->empleado->segundo_apellido;
                    $monto_hrs_extra = (((($detalle->salario_bruto/30)/8)*$detalle->cantidad_hrs_extra)*2);
                    $salario = $detalle->salario_bruto +  $monto_hrs_extra + $detalle->antiguedad_monto;
                    $deducciones = $detalle->ir + ($detalle->salario_bruto*0.07);
                    $neto_recibir = $salario - $deducciones;
                @endphp
                    <tr>
                        <td>{{ $detalle->id_empleado }}</td>
                        <td>{{ $nombre_completo }}</td>
                        <td>{{ $detalle->empleado->cargo }}</td>
                        <td>{{ number_format($detalle->salario_bruto, 2) }}</td>
                        <td>{{ $detalle->cantidad_hrs_extra }}</td>
                        <td>{{ number_format($monto_hrs_extra, 2) }}</td>
                        <td>{{ $detalle->empleado->antiguedad }}</td>
                        <td>{{ number_format($detalle->antiguedad_porcentaje, 2) }}</td>
                        <td>{{ number_format($detalle->antiguedad_monto, 2) }}</td>
                        <td>{{ number_format($salario, 2) }}</td>
                        <td>{{ number_format($detalle->salario_bruto * 0.07, 2) }}</td>
                        <td>{{ number_format($detalle->ir, 2) }}</td>
                        <td>{{ number_format($deducciones, 2) }}</td>
                        <td>{{ number_format($neto_recibir, 2) }}</td>
                        <td>{{ number_format($detalle->inss_patronal, 2) }}</td>
                        <td>{{ number_format($detalle->salario_bruto * 0.02, 2) }}</td>
                        <td>{{ number_format($detalle->vacaciones, 2) }}</td>
                        <td>{{ number_format($detalle->treceavo_mes, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Botón para imprimir -->
<button onclick="window.print()" class="bg-blue-500 text-white font-bold py-2 px-4 rounded mb-4">
    Imprimir Nómina
</button>

@endsection
