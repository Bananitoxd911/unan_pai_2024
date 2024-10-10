@extends('layouts.nomina')

@section('contenido')


<div class="container mx-auto bg-white p-5 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">Cálculo de Liquidación</h1>
    
    <form id="liquidacionForm">
        <div>
            <label class="block mb-1">Tipo de Salario:</label>
            <input type="radio" name="tipo_salario" value="fijo" onchange="mostrarSalarios()" checked> Fijo
            <input type="radio" name="tipo_salario" value="variable" onchange="mostrarSalarios()"> Variable
        </div>

        <div id="salariosSeccion" style="display: none;">
            <h2 class="text-lg font-semibold mt-4">Ingrese los salarios de los últimos 6 meses:</h2>
            <input type="number" id="salario1" placeholder="Salario Mes 1" class="input mt-2"/>
            <input type="number" id="salario2" placeholder="Salario Mes 2" class="input mt-2"/>
            <input type="number" id="salario3" placeholder="Salario Mes 3" class="input mt-2"/>
            <input type="number" id="salario4" placeholder="Salario Mes 4" class="input mt-2"/>
            <input type="number" id="salario5" placeholder="Salario Mes 5" class="input mt-2"/>
            <input type="number" id="salario6" placeholder="Salario Mes 6" class="input mt-2"/>
        </div>

        <div>
            <label class="block mb-1 mt-4">Salario Mensual:</label>
            <input type="number" id="salario" placeholder="Salario Mensual" class="input mt-2" />
        </div>

        <div>
            <label class="block mb-1 mt-4">Frecuencia de Pago:</label>
            <select id="frecuencia" class="input mt-2">
                <option value="mensual">Mensual</option>
                <option value="quincenal">Quincenal</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 mt-4">Vacaciones No Gozadas:</label>
            <input type="number" id="vacaciones_no_gozadas" placeholder="Vacaciones No Gozadas" class="input mt-2" />
        </div>

        <div>
            <label class="block mb-1 mt-4">Fecha de Inicio:</label>
            <input type="date" id="fechaInicio" class="input mt-2" required />
        </div>

        <div>
            <label class="block mb-1 mt-4">Fecha de Término:</label>
            <input type="date" id="fechaTermino" class="input mt-2" required />
        </div>

        <div>
            <label class="block mb-1 mt-4">Despido Justificado:</label>
            <input type="radio" name="despido" value="justificado" checked> Sí
            <input type="radio" name="despido" value="no_justificado"> No
        </div>

        <button type="button" onclick="calcularLiquidacion()" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Calcular Liquidación</button>
    </form>

    <div id="resultados" class="mt-4"></div>
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
        const antiguedad = Math.floor((fechaTermino - fechaInicio) / (1000 * 60 * 60 * 24 * 30)); // Calcular la antigüedad en meses
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