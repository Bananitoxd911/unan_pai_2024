@extends('layouts.nomina')

@section('contenido')
<style>
    @media print {
        .tabla-mostrar {
            position: absolute;
            left: 0;
            font-size: 0.4rem;
        }

        table {
            width: 100%;
            font-size: 0.4rem;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
            margin: 0;
            text-align: center;
        }

        button {
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

        <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-200">Nómina - {{ $nomina->nomina->fecha }}</h1>
        <h2 class="text-xl mb-4 text-gray-700 dark:text-gray-300">Total: C$ {{ $nomina->nomina->total }}</h2>
        <h3 class="text-lg font-semibold mb-2 text-gray-700 dark:text-gray-300">Detalles de la Nómina</h3>
        
        <table class="min-w-full bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700 shadow-lg">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-300 uppercase text-xs leading-normal">
                    <th class="py-2 px-4 border-b dark:border-gray-600">N°</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">Nombre Completo</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">Cargo</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">Salario Bruto</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">Horas Extras</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">Monto Extras</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">Antigüedad (Años)</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">Antigüedad %</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">Antigüedad Monto</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">Total Ingresos</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">INSS Laboral</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">IR</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">Total Deducciones</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">Neto a Recibir</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">INSS Patronal</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">INATEC</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">Vacaciones</th>
                    <th class="py-2 px-4 border-b dark:border-gray-600">13° Mes</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 dark:text-gray-400 font-light">
            @foreach($detalles as $detalle)
                @php
                    $empleado = optional($detalle->detalle->empresaempleado->empleado);
                    $nombre_completo = $empleado ? ($empleado->primer_nombre . ' ' . $empleado->segundo_nombre . ' ' . $empleado->primer_apellido . ' ' . $empleado->segundo_apellido) : 'Empleado no encontrado';
                    $cargo = $empleado ? ($empleado->departamentocargo->cargo->nombre ?? 'N/A') : 'N/A';
                    $monto_hrs_extra = $detalle->detalle->monto_hrs_extra;
                    $salario = $detalle->detalle->total_ingreso;
                    $deducciones = $detalle->detalle->total_deducciones;
                    $antiguedad_monto = $detalle->detalle->antiguedad_porcentaje * $empleado->salario_bruto / 100;
                    $neto_recibir = $detalle->detalle->neto_recibir;
                @endphp
                
                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-center text-xs">
                    <td class="py-2 px-4">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4">{{ $nombre_completo }}</td>
                    <td class="py-2 px-4">{{ $cargo }}</td>
                    <td class="py-2 px-4">{{ number_format($empleado ? $empleado->salario_bruto : 0, 2) }}</td>
                    <td class="py-2 px-4">{{ $detalle->detalle->cantidad_hrs_extras }}</td>
                    <td class="py-2 px-4">{{ number_format($monto_hrs_extra, 2) }}</td>
                    <td class="py-2 px-4">{{ $empleado ? $empleado->antiguedad : 0 }}</td>
                    <td class="py-2 px-4">{{ number_format($detalle->detalle->antiguedad_porcentaje, 2) }}</td>
                    <td class="py-2 px-4">{{ number_format($antiguedad_monto, 2) }}</td>
                    <td class="py-2 px-4">{{ number_format($detalle->detalle->total_ingreso, 2) }}</td>
                    <td class="py-2 px-4">{{ number_format($detalle->detalle->inss_laboral, 2) }}</td>
                    <td class="py-2 px-4">{{ number_format($detalle->detalle->ir, 2) }}</td>
                    <td class="py-2 px-4">{{ number_format($detalle->detalle->total_deducciones, 2) }}</td>
                    <td class="py-2 px-4">{{ number_format($neto_recibir, 2) }}</td>
                    <td class="py-2 px-4">{{ number_format($detalle->detalle->inss_patronal, 2) }}</td>
                    <td class="py-2 px-4">{{ number_format($detalle->detalle->inatec, 2) }}</td>
                    <td class="py-2 px-4">{{ number_format($detalle->detalle->vacaciones, 2) }}</td>
                    <td class="py-2 px-4">{{ number_format($detalle->detalle->treceavomes, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<button onclick="window.print()" class="bg-blue-500 text-white font-bold py-2 px-4 rounded mb-4 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600">
    Imprimir Nómina
</button>

@endsection
