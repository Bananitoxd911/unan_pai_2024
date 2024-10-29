@extends('layouts.nomina')

@section('contenido')

<div class="container mx-auto bg-white dark:bg-slate-900 p-6 rounded-lg shadow-lg w-full grid justify-items-center">
    <h1 class="text-3xl font-bold mb-6 text-center text-blue-600">Cálculo de Indemnización</h1>
    
    <form id="liquidacionForm" class="space-y-4 bg-slate-800 p-10 rounded-xl">
        <div>
            <label class="block mb-2 font-medium">Tipo de Salario:</label>
            <div class="flex items-center space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="tipo_salario" value="fijo" onchange="mostrarSalarios()" checked class="form-radio text-blue-600">
                    <span class="ml-2">Fijo</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="tipo_salario" value="variable" onchange="mostrarSalarios()" class="form-radio text-blue-600">
                    <span class="ml-2">Variable</span>
                </label>
            </div>
        </div>

        <div id="salariosSeccion" style="display: none;" class="space-y-2">
            <h2 class="text-lg font-semibold mt-4">Ingrese los salarios de los últimos 6 meses:</h2>
            @for ($i = 1; $i <= 6; $i++)
                <input type="number" id="salario{{ $i }}" placeholder="Salario Mes {{ $i }}" class="input dark:bg-slate-700 dark:text-white  mt-2 border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            @endfor
        </div>

        <div>
            <label class="block mb-2 font-medium">Salario Mensual:</label>
            <input  type="number" id="salario" placeholder="Salario Mensual" class="input dark:bg-slate-700 dark:text-white  mt-2 border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label class="block mb-2 font-medium">Frecuencia de Pago:</label>
            <select id="frecuencia" class="input dark:bg-slate-700 dark:text-white  mt-2 border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="mensual">Mensual</option>
                <option value="quincenal">Quincenal</option>
            </select>
        </div>

        <div>
            <label class="block mb-2 font-medium">Vacaciones No Gozadas:</label>
            <input  type="number" id="vacaciones_no_gozadas" placeholder="Vacaciones No Gozadas" class="input dark:bg-slate-700 dark:text-white  mt-2 border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-2 font-medium">Fecha de Inicio:</label>
                <input  type="date" id="fechaInicio" class="input dark:bg-slate-700 dark:text-white  mt-2 border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
            </div>

            <div>
                <label class="block mb-2 font-medium">Fecha de Término:</label>
                <input  type="date" id="fechaTermino" class="input dark:bg-slate-700 dark:text-white  mt-2 border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
            </div>
        </div>


        <div>
            <label class="block mb-2 font-medium">Despido Justificado:</label>
            <div class="flex items-center space-x-4">
                <label class="inline-flex items-center">
                    <input  type="radio" name="despido" value="justificado" checked class="form-radio text-blue-600">
                    <span class="ml-2">Sí</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="despido" value="no_justificado" class="form-radio text-blue-600">
                    <span class="ml-2">No</span>
                </label>
            </div>
        </div>

        <button type="button" onclick="calcularLiquidacion()" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">Calcular Liquidación</button>
    </form>

    <div id="resultados" class="mt-6 p-4 bg-gray-100 dark:bg-slate-800 rounded-md shadow-md"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        mostrarSalarios();
    });

    function mostrarSalarios() {
        const tipoSalario = document.querySelector('input[name="tipo_salario"]:checked').value;
        const salarioMensual = document.getElementById('salario');
        const seccionSalarios = document.getElementById('salariosSeccion');

        if (seccionSalarios) {
            if (tipoSalario === 'variable') {
                salarioMensual.style.display = 'none';
                seccionSalarios.style.display = 'block';
            } else {
                salarioMensual.style.display = 'block';
                seccionSalarios.style.display = 'none';
            }
        }
    }

    function calcularLiquidacion() {
        const fechaInicio = new Date(document.getElementById('fechaInicio').value);
        const fechaTermino = new Date(document.getElementById('fechaTermino').value);
        //Agregar empleados
        //const antiguedad = Math.floor((fechaTermino - fechaInicio) / (1000 * 60 * 60 * 24 * 30)); // Calcular la antigüedad en meses
        const salarioFijo = parseFloat(document.getElementById('salario').value) || 0;
        const vacacionesNoGozadas = parseFloat(document.getElementById('vacaciones_no_gozadas').value) || 0;
        const despido = document.querySelector('input[name="despido"]:checked').value;
        const tipoSalario = document.querySelector('input[name="tipo_salario"]:checked').value;

        let salarioVariable = 0;

        if (tipoSalario === 'variable') {
            const salariosUltimosMeses = [
                parseFloat(document.getElementById('salario1').value) || 0,
                parseFloat(document.getElementById('salario2').value) || 0,
                parseFloat(document.getElementById('salario3').value) || 0,
                parseFloat(document.getElementById('salario4').value) || 0,
                parseFloat(document.getElementById('salario5').value) || 0,
                parseFloat(document.getElementById('salario6').value) || 0
            ];
            salarioVariable = salariosUltimosMeses.reduce((a, b) => a + b, 0) / salariosUltimosMeses.length;
        }

        const vacaciones = (tipoSalario === 'fijo' ? salarioFijo : salarioVariable) / 30 * vacacionesNoGozadas;
        const aguinaldo = tipoSalario === 'fijo' ? salarioFijo : salarioVariable;
        const indemnizacion = despido === 'no_justificado' ? (tipoSalario === 'fijo' ? salarioFijo * (antiguedad / 12) : (salarioVariable * 0.5) * (antiguedad / 12)) : 0;
        const preaviso = despido === 'no_justificado' ? (tipoSalario === 'fijo' ? salarioFijo : salarioVariable) : 0;

        const totalLiquidacion = vacaciones + aguinaldo + indemnizacion + preaviso;

        document.getElementById('resultados').innerHTML = `
            <h2 class="text-lg font-bold mt-4">Resultados de Liquidación</h2>
            <ul class="list-disc ml-5">
                <li>Vacaciones No Gozadas: C$ ${vacaciones.toFixed(2)}</li>
                <li>Aguinaldo: C$ ${aguinaldo.toFixed(2)}</li>
                <li>Indemnización: C$ ${indemnizacion.toFixed(2)}</li>
                <li>Preaviso: C$ ${preaviso.toFixed(2)}</li>
                <li><strong>Total Liquidación: C$ ${totalLiquidacion.toFixed(2)}</strong></li>
            </ul>
        `;
    }
</script>

@endsection
