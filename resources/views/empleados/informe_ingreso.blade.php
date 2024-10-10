
@extends('layouts.nomina')

@section('contenido')

<style>
    .tabcontent {
        display: none;
        padding: 20px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .tablink {
        background-color: #f1f1f1;
        color: black;
        padding: 14px 16px;
        cursor: pointer;
        border: none;
    }

.tablink.active {
        background-color: #ccc;
    }

</style>
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">Buscar Ingresos y Deducciones del Empleado</h2>

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


    <div class="tabs">
        <button class="tablink" onclick="openTab(event, 'ingresos')">Ingresos y Deducciones</button>
        <button class="tablink" onclick="openTab(event, 'indemnizacion')">Indemnización</button>
    </div>

    <div id="ingresos" class="tabcontent">
        <!-- Tabla de Ingresos y Deducciones -->
        <div id="resultadosNomina"></div>
    </div>

    <div id="indemnizacion" class="tabcontent" style="display:none;">
        <h3 class="text-xl font-semibold mb-4">Cálculo de Indemnización</h3>
        <form>
            <div class="mb-4">
                <label for="antiguedad_anios" class="block">Años de antigüedad:</label>
                <input type="number" id="antiguedad_anios" placeholder="Años" class="border">
            </div>
            <div class="mb-4">
                <label for="antiguedad_meses" class="block">Meses de antigüedad:</label>
                <input type="number" id="antiguedad_meses" placeholder="Meses" class="border">
            </div>
            <div class="mb-4">
                <label for="antiguedad_dias" class="block">Días de antigüedad:</label>
                <input type="number" id="antiguedad_dias" placeholder="Días" class="border">
            </div>
            <div class="mb-4">
                <label for="salario_diario" class="block">Salario por día:</label>
                <input type="number" id="salario_diario" placeholder="Salario por día" class="border">
            </div>
            <div class="mb-4">
                <button type="button" onclick="calcularIndenmizacion()">Calcular Indemnización</button>
            </div>

            <div class="mb-4">
                <label for="indemnizacion_dias" class="block">Días de indemnización:</label>
                <input type="text" id="indemnizacion_dias" readonly class="border">
            </div>
            <div class="mb-4">
                <label for="indemnizacion_total" class="block">Total de indemnización (C$):</label>
                <input type="text" id="indemnizacion_total" readonly class="border">
            </div>
        </form>
    </div>






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
                    <div class="grid place-items-center">
                        <h3 class="text-xl font-semibold mb-4">Resultados para el empleado ${data.empleado}</h3>
                        <table id="tablaNomina" class="table-auto w-2/5 text-left border-collapse border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 bg-gray-100" colspan="2">Datos del Empleado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-semibold">Nombre empleado:</td>
                                    <td class="border border-gray-300 px-4 py-2">${data.empleado}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-semibold">Cédula:</td>
                                    <td class="border border-gray-300 px-4 py-2">${data.numero_inss}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-semibold">Salario Bruto:</td>
                                    <td class="border border-gray-300 px-4 py-2">C$${data.salario_bruto}</td>
                                </tr>

                                <!-- Sección de Ingresos -->
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 bg-gray-100" colspan="2">Ingresos</th>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">Horas Extras</td>
                                    <td class="border border-gray-300 px-4 py-2">C$${data.horas_extra}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">Antigüedad</td>
                                    <td class="border border-gray-300 px-4 py-2">C$${data.antiguedad_monto}</td>
                                </tr>

                                <!-- Sección de Deducciones -->
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 bg-gray-100" colspan="2">Deducciones</th>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">INSS Laboral</td>
                                    <td class="border border-gray-300 px-4 py-2">C$${data.inss}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">IR</td>
                                    <td class="border border-gray-300 px-4 py-2">C$${data.ir}</td>
                                </tr>

                                <!-- Sección de Totales -->
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 bg-gray-100" colspan="2">Totales</th>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-bold">Total Ingresos</td>
                                    <td class="border border-gray-300 px-4 py-2 font-bold">C$${data.total_ingresos}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-bold">Total Deducciones</td>
                                    <td class="border border-gray-300 px-4 py-2 font-bold">C$${data.total_deducciones}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-bold">Neto a Recibir</td>
                                    <td class="border border-gray-300 px-4 py-2 font-bold">C$${data.neto_recibir}</td>
                                </tr>
                            </tbody>
                        </table>
                        <button onclick="imprimirNomina()" class="bg-blue-500 text-white px-4 py-2 mt-4">Imprimir Nómina</button>
                    </div>
                    `;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        } else {
            alert('Por favor seleccione un empleado y un mes.');
        }
    }

    function imprimirNomina() {
        var contenido = document.getElementById('tablaNomina').outerHTML;
        var ventanaImpresion = window.open('', '_blank', 'width=800,height=600');
        ventanaImpresion.document.write(`
            <html>
                <head>
                    <title>Imprimir Nómina</title>
                    <style>
                        table {
                            width: 50%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid black;
                            padding: 8px;
                            text-align: left;
                        }
                        th {
                            background-color: #f2f2f2;
                        }
                    </style>
                </head>
                <body>
                    ${contenido}
                </body>
            </html>
        `);
        ventanaImpresion.document.close();
        ventanaImpresion.focus();
        ventanaImpresion.print();
        ventanaImpresion.close();
    }
</script>

<script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

</script>


<script>
    function calcularIndenmizacion() {
        // Extraemos los valores del informe de ingresos y deducciones.
        var salarioBruto = parseFloat(document.getElementById('salario_bruto').textContent.replace('C$', '')) || 0;
        var antiguedadTiempo = {
            anios: parseInt(document.getElementById('antiguedad_anios').value) || 0,
            meses: parseInt(document.getElementById('antiguedad_meses').value) || 0,
            dias: parseInt(document.getElementById('antiguedad_dias').value) || 0
        };

        // Calculamos el salario por día basado en el salario bruto
        var salarioPorDia = salarioBruto / 30;

        var aniosTiempo = antiguedadTiempo.anios;
        var mesesTiempo = antiguedadTiempo.meses;
        var diasTiempo = antiguedadTiempo.dias;

        // Lógica de cálculo de indemnización
        var indem_primerosTresAnio = aniosTiempo <= 3 ? aniosTiempo * 30 : 3 * 30;
        var indem_cuartoAnio = aniosTiempo > 3 ? (aniosTiempo - 3) * 20 : 0;
        var indem_meses = aniosTiempo >= 3 ? (20 / 12) * mesesTiempo : (30 / 12) * mesesTiempo;
        var indem_dias = aniosTiempo >= 3 ? (20 / 12 / 30) * diasTiempo : (30 / 12 / 30) * diasTiempo;
        var indem_totalDias = indem_primerosTresAnio + indem_cuartoAnio + indem_meses + indem_dias;

        if (indem_totalDias > 150) {
            indem_totalDias = 150;
        }

        // Calculamos la indemnización total
        var indemnizacionTotal = salarioPorDia * indem_totalDias;

        // Actualizamos los campos de indemnización en la vista
        document.getElementById('indemnizacion_total').value = indemnizacionTotal.toFixed(2);
        document.getElementById('indemnizacion_dias').value = indem_totalDias.toFixed(2);
    }
</script>

@endsection