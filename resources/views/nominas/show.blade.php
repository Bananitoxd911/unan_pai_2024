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

        button {
            visibility: hidden; /* Oculta el botón en impresión */
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
                <tr class="bg-gray-100 text-black uppercase leading-normal text-xs">
                    <th>N°</th>
                    <th>Nombre Completo</th>
                    <th>Cargo</th>
                    <th>Salario Bruto</th>
                    <th>Horas Extras</th>
                    <th>Monto Extras</th>
                    <th>Antigüedad (Años)</th>
                    <th>Antigüedad %</th>
                    <th>Antigüedad Monto</th>
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
            <tbody class="text-gray-600 font-light">
            @foreach($detalles as $detalle)
                @php
                    // Acceder al empleado a través de la estructura anidada
                    $empleado = optional($detalle->detalle->empresaempleado->empleado);

                    // Formar el nombre completo del empleado
                    $nombre_completo = $empleado ? ($empleado->primer_nombre . ' ' . $empleado->segundo_nombre . ' ' . $empleado->primer_apellido . ' ' . $empleado->segundo_apellido) : 'Empleado no encontrado';
                    
                    // Obtener el cargo, si es necesario
                    $cargo = $empleado ? ($empleado->departamentocargo->cargo->nombre ?? 'N/A') : 'N/A'; // Asegúrate de que 'cargo' esté definido en el modelo Empleado
                    
                    // Calcular otros valores según tu lógica
                    $monto_hrs_extra = $detalle->detalle->monto_hrs_extra; // Supongo que es un monto ya calculado
                    $salario = $detalle->detalle->total_ingreso; // Total ingreso puede ser el salario bruto más extras y antigüedad
                    $deducciones = $detalle->detalle->total_deducciones;
                    $antiguedad_monto = $detalle->detalle->antiguedad_porcentaje * $empleado->salario_bruto / 100;
                    $neto_recibir = $detalle->detalle->neto_recibir;
                @endphp
                
                <tr class="text-center font-light text-xs">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $nombre_completo }}</td>
                    <td>{{ $cargo }}</td>
                    <td>{{ number_format($empleado ? $empleado->salario_bruto : 0, 2) }}</td>
                    <td>{{ $detalle->detalle->cantidad_hrs_extras }}</td>
                    <td>{{ number_format($monto_hrs_extra, 2) }}</td>
                    <td>{{ $empleado ? $empleado->antiguedad : 0 }}</td>
                    <td>{{ number_format($detalle->detalle->antiguedad_porcentaje, 2) }}</td>
                    <td>{{ number_format($antiguedad_monto, 2) }}</td>
                    <td>{{ number_format($detalle->detalle->total_ingreso, 2) }}</td>
                    <td>{{ number_format($detalle->detalle->inss_laboral, 2) }}</td>
                    <td>{{ number_format($detalle->detalle->ir, 2) }}</td>
                    <td>{{ number_format($detalle->detalle->total_deducciones, 2) }}</td>
                    <td>{{ number_format($neto_recibir, 2) }}</td>
                    <td>{{ number_format($detalle->detalle->inss_patronal, 2) }}</td>
                    <td>{{ number_format($detalle->detalle->inatec, 2) }}</td>
                    <td>{{ number_format($detalle->detalle->vacaciones, 2) }}</td>
                    <td>{{ number_format($detalle->detalle->treceavomes, 2) }}</td>
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
