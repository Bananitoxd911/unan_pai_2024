
@extends('layouts.nomina')

@section('contenido')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-6">Buscar Ingresos y Deducciones del Empleado</h2>

    <form id="searchNominaForm" class="max-w-lg mx-auto">
        <!-- Select para elegir el empleado -->
        <div class="mb-4">
            <label for="empleado" class="block text-sm font-medium text-gray-700">Empleado:</label>
            <select id="empleado" name="empleado" class="block w-full mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="" disabled selected>Seleccione un empleado</option>
                <!-- Aquí puedes iterar sobre empleados y llenar el select con sus datos -->
                @foreach ($empleados as $empleado)
                    <option value="{{ $empleado->id }}">{{ $empleado->primer_nombre }} {{ $empleado->primer_apellido }}</option>
                @endforeach
            </select>
        </div>

        <!-- Select para elegir el mes -->
        <div class="mb-4">
            <label for="mes" class="block text-sm font-medium text-gray-700">Mes:</label>
            <select id="mes" name="mes" class="block w-full mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="" disabled selected>Seleccione un mes</option>
                <option value="01">Enero</option>
                <option value="02">Febrero</option>
                <option value="03">Marzo</option>
                <option value="04">Abril</option>
                <option value="05">Mayo</option>
                <option value="06">Junio</option>
                <option value="07">Julio</option>
                <option value="08">Agosto</option>
                <option value="09">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>
        </div>

        <!-- Botón para buscar -->
        <button type="button" onclick="buscarNomina()" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700">Buscar</button>
    </form>

    <!-- Aquí mostraremos los resultados de ingresos y deducciones -->
    <div id="resultadosNomina" class="mt-6"></div>
</div>

<script>
    function buscarNomina() {
        const empleadoId = document.getElementById('empleado').value;
        const mes = document.getElementById('mes').value;

        if (empleadoId && mes) {
            fetch(`/nomina/empleado/${empleadoId}/mes/${mes}`)
                .then(response => response.json())
                .then(data => {
                    let resultados = document.getElementById('resultadosNomina');
                    resultados.innerHTML = `
                        <h3 class="text-xl font-semibold">Resultados para el empleado ${data.empleado} en el mes ${data.mes}</h3>
                        <p><strong>Salario Bruto:</strong> C$${data.salario_bruto}</p>
                        <p><strong>Horas Extras:</strong> ${data.cantidad_hrs_extra} horas</p>
                        <p><strong>Antigüedad (Monto):</strong> C$${data.antiguedad_monto}</p>
                        <p><strong>IR:</strong> C$${data.ir}</p>
                        <p><strong>INSS Patronal:</strong> C$${data.inss_patronal}</p>
                        <p><strong>Vacaciones:</strong> C$${data.vacaciones}</p>
                        <p><strong>Treceavo Mes:</strong> C$${data.treceavo_mes}</p>
                        <p><strong>Total Ingresos:</strong> C$${data.total_ingresos}</p>
                        <p><strong>Total Deducciones:</strong> C$${data.total_deducciones}</p>
                    `;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        } else {
            alert('Por favor seleccione un empleado y un mes.');
        }
    }
</script>
@endsection