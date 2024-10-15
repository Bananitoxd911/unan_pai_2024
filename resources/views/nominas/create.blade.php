@extends('layouts.nomina')

@section('contenido')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Crear Nómina</h1>
    <form action="{{ route('nominas.store') }}" method="POST">
        @csrf
        @include('nominas.partials.superior')

        <h3 class="text-xl font-semibold mb-4">Detalles de Nómina</h3>
        <div class="overflow-x-auto">
            @include('nominas.partials.tabla')
        </div>
        <button type="button" id="add-detail" class="mt-4 bg-black text-white px-4 py-2 rounded-md">Agregar Detalle</button>
        <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Guardar</button>
    </form>
</div>

<script>
    document.getElementById('add-detail').addEventListener('click', function () {
        var tableBody = document.getElementById('detalles-table').querySelector('tbody');
        var index = tableBody.querySelectorAll('tr').length;
        var newRow = `
            <tr>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][numero]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" required></td>
                <td class="px-4 py-2"><input type="text" name="detalles[${index}][no_inss]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" required disabled></td>
                <td class="px-4 py-2">
                    <select name="detalles[${index}][id_empleado]" class="empleado-select form-control w-full bg-gray-100 border border-gray-300 rounded-md" required>
                        @foreach($empleados as $empleado)
                            @php
                                $nombre_completo = $empleado->primer_nombre . " " . $empleado->segundo_nombre . " " . $empleado->primer_apellido . " " . $empleado->segundo_apellido;
                            @endphp
                            <option value="{{ $empleado->id }}" 
                                    data-no-inss="{{ $empleado->numero_inss }}" 
                                    data-cargo="{{ $empleado->cargo }}" 
                                    data-salario="{{ $empleado->salario_bruto }}"
                                    data-antiguedad-ano="{{ $empleado->antiguedad}}">
                                    
                                {{ $nombre_completo }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td class="px-4 py-2"><input type="text" name="detalles[${index}][cargo]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" required disabled></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][salario_bruto]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" disabled required></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][cantidad_hrs_extra]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" required></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][hrs_extra_c]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" disabled required></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][antiguedad_anos]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" disabled required></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][antiguedad_porcentaje]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][antiguedad_monto]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" disabled required></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][total_ingresos]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" disabled required></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][inss_laboral]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" disabled required></td>
                
                <td class="px-4 py-2">
                    <input type="number" name="detalles[${index}][ir]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" disabled required>
                    <!-- Botón para abrir el modal para cada fila -->
                    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded" onclick="abrirModal(${index})">Calcular IR</button>
                </td>



                <td class="px-4 py-2"><input type="number" name="detalles[${index}][total_deducciones]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" disabled required></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][neto_recibir]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" disabled required></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][inss_patronal]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" disabled required></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][inatec]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" disabled required></td>
                <td class="px-4 py-2">
                    <input type="number" name="detalles[${index}][vacaciones]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" disabled required>
                    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded" onclick="abrirModalVacaciones(${index})">Calcular Vacaciones</button>

                </td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][treceavo_mes]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" disabled required></td>
                <td class="px-4 py-2"><button type="button" class="btn btn-danger remove-row bg-red-500 text-white px-4 py-2 rounded-md">Eliminar</button></td>
            </tr>`;
        tableBody.insertAdjacentHTML('beforeend', newRow);
    });

    document.getElementById('detalles-table').addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-row')) {
            event.target.closest('tr').remove();
        }
    });
</script>



<script>
    $(document).ready(function() {
        // Delegación de eventos para manejar selects dinámicos
        $('#detalles-table').on('change', '.empleado-select', function() {
            // Obtener la fila actual donde está el select
            var $row = $(this).closest('tr');

            // Obtener los datos del empleado seleccionado
            var noInss = $(this).find('option:selected').data('no-inss');
            var cargo = $(this).find('option:selected').data('cargo');
            var salario = $(this).find('option:selected').data('salario');
            var antiguedad = $(this).find('option:selected').data('antiguedad-ano');

            console.log(antiguedad);
            // Actualizar los campos correspondientes en la fila actual
            $row.find('input[name^="detalles"][name$="[no_inss]"]').val(noInss);
            $row.find('input[name^="detalles"][name$="[cargo]"]').val(cargo);
            $row.find('input[name^="detalles"][name$="[salario_bruto]"]').val(salario);
            $row.find('input[name^="detalles"][name$="[antiguedad_anos]"]').val(antiguedad);
            $row.find('input[name^="detalles"][name$="[inss_laboral]"]').val((salario * 0.07).toFixed(2));

        });
    });
</script>


<script>
// Escuchar cambios en los inputs de salario y horas extras
document.addEventListener('DOMContentLoaded', function () {
    // Función para calcular horas extras
    function calcularHorasExtras(index) {
        const salarioInput = document.querySelector(`input[name="detalles[${index}][salario_bruto]"]`);
        const horasExtrasInput = document.querySelector(`input[name="detalles[${index}][cantidad_hrs_extra]"]`);
        const resultadoInput = document.querySelector(`input[name="detalles[${index}][hrs_extra_c]"]`);

        const salarioBruto = parseFloat(salarioInput.value) || 0;
        const cantidadHorasExtras = parseFloat(horasExtrasInput.value) || 0;

        // Calcular el salario diario
        const salarioDiario = salarioBruto / 30;
        // Calcular el valor de la hora
        const valorHora = salarioDiario / 8;

        // Calcular el total de horas extras
        const totalHorasExtras = (valorHora * cantidadHorasExtras) * 2; // factor 2 por horas extras

        // Asignar el resultado al input correspondiente
        resultadoInput.value = totalHorasExtras.toFixed(2); // Redondear a 2 decimales
    }

    // Función para agregar listeners a los inputs de una fila específica
    function agregarListeners(index) {
        const salarioInput = document.querySelector(`input[name="detalles[${index}][salario_bruto]"]`);
        const horasExtrasInput = document.querySelector(`input[name="detalles[${index}][cantidad_hrs_extra]"]`);

        salarioInput.addEventListener('input', () => calcularHorasExtras(index));
        horasExtrasInput.addEventListener('input', () => calcularHorasExtras(index));
    }

    // Inicializar listeners para las filas existentes
    const filas = document.querySelectorAll('#detalles-table tbody tr'); // Asegúrate de que solo contenga las filas relevantes
    filas.forEach((fila, index) => {
        agregarListeners(index);
    });

    // Delegar el evento de cambio para filas nuevas
    document.getElementById('detalles-table').addEventListener('input', function (event) {
        if (event.target.matches('input[name*="[salario_bruto]"]') || event.target.matches('input[name*="[cantidad_hrs_extra]"]')) {
            // Obtener el índice de la fila correspondiente
            const rowIndex = Array.from(document.querySelectorAll('#detalles-table tbody tr')).indexOf(event.target.closest('tr'));
            calcularHorasExtras(rowIndex);
        }
    });
});
</script>


<script>
// Escuchar cambios en los inputs de antigüedad
document.addEventListener('DOMContentLoaded', function () {
    // Función para calcular el monto de antigüedad
    function calcularAntiguedad(index) {
        const antiguedadAnosInput = document.querySelector(`input[name="detalles[${index}][antiguedad_anos]"]`);
        const porcentajeInput = document.querySelector(`input[name="detalles[${index}][antiguedad_porcentaje]"]`);
        const montoInput = document.querySelector(`input[name="detalles[${index}][antiguedad_monto]"]`);
        const salarioInput = document.querySelector(`input[name="detalles[${index}][salario_bruto]"]`);

        const antiguedadAnos = parseFloat(antiguedadAnosInput.value) || 0; // Años
        const salarioBruto = parseFloat(salarioInput.value) || 0; // Salario Bruto
        const porcentajeAntiguedad = parseFloat(porcentajeInput.value) || 0; // Porcentaje

        // Calcular el monto de antigüedad
        const montoAntiguedad = (salarioBruto * (porcentajeAntiguedad / 100));

        // Asignar el resultado al input correspondiente
        montoInput.value = montoAntiguedad.toFixed(2); // Redondear a 2 decimales
    }

    // Función para agregar listeners a los inputs de una fila específica
    function agregarListeners(index) {
        const antiguedadAnosInput = document.querySelector(`input[name="detalles[${index}][antiguedad_anos]"]`);
        const porcentajeInput = document.querySelector(`input[name="detalles[${index}][antiguedad_porcentaje]"]`);
        const salarioInput = document.querySelector(`input[name="detalles[${index}][salario_bruto]"]`);

        // Solo agregar listeners si los inputs existen
        if (antiguedadAnosInput) {
            antiguedadAnosInput.addEventListener('input', () => calcularAntiguedad(index));
        }
        if (porcentajeInput) {
            porcentajeInput.addEventListener('input', () => calcularAntiguedad(index));
        }
        if (salarioInput) {
            salarioInput.addEventListener('input', () => calcularAntiguedad(index));
        }
    }

    // Inicializar listeners para las filas existentes
    const filas = document.querySelectorAll('#detalles-table tbody tr'); // Asegúrate de que solo contenga las filas relevantes
    filas.forEach((fila, index) => {
        agregarListeners(index);
    });

    // Delegar el evento de cambio para filas nuevas (si es necesario)
    document.getElementById('detalles-table').addEventListener('input', function (event) {
        if (event.target.matches('input[name*="[antiguedad_anos]"]') || 
            event.target.matches('input[name*="[antiguedad_porcentaje]"]') || 
            event.target.matches('input[name*="[salario_bruto]"]')) {
            // Obtener el índice de la fila correspondiente
            const rowIndex = Array.from(document.querySelectorAll('#detalles-table tbody tr')).indexOf(event.target.closest('tr'));
            calcularAntiguedad(rowIndex);
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Función para calcular el total de ingresos
    function calcularTotalIngresos(index) {
        const salarioBrutoInput = document.querySelector(`input[name="detalles[${index}][salario_bruto]"]`);
        const horasExtrasInput = document.querySelector(`input[name="detalles[${index}][hrs_extra_c]"]`);
        const antiguedadMontoInput = document.querySelector(`input[name="detalles[${index}][antiguedad_monto]"]`);
        const totalIngresosInput = document.querySelector(`input[name="detalles[${index}][total_ingresos]"]`);

        // Obtener valores y manejarlos como números
        const salarioBruto = parseFloat(salarioBrutoInput.value) || 0;
        const horasExtras = parseFloat(horasExtrasInput.value) || 0;
        const antiguedadMonto = parseFloat(antiguedadMontoInput.value) || 0;

        // Calcular el total de ingresos
        const totalIngresos = salarioBruto + horasExtras + antiguedadMonto;

        // Asignar el resultado al input correspondiente
        totalIngresosInput.value = totalIngresos.toFixed(2); // Redondear a 2 decimales
    }

    // Función para calcular el total de ingresos para todas las filas
    function calcularTotalParaTodasLasFilas() {
        const filas = document.querySelectorAll('#detalles-table tbody tr');
        filas.forEach((fila, index) => {
            calcularTotalIngresos(index);
        });
    }

    // Agregar listener al botón de cálculo
    document.getElementById('calcularTotal').addEventListener('click', calcularTotalParaTodasLasFilas);
});
</script>






<script>
    let filaIndex = null;

    // Función para abrir el modal y pasar el índice de la fila
    function abrirModal(index) {
        filaIndex = index;
        document.getElementById('modalIR').classList.remove('hidden');
    }

    // Función para cerrar el modal
    function cerrarModal() {
        document.getElementById('modalIR').classList.add('hidden');
    }

    // Función para calcular el IR y asignar el resultado al input correspondiente de la fila
    document.getElementById('calcularIRBtn').addEventListener('click', function () {
        const impuestoBase = parseFloat(document.getElementById('impuestoBase').value);
        const porcentaje = parseFloat(document.getElementById('porcentaje').value);
        const sobreExceso = parseFloat(document.getElementById('sobreExceso').value);

        // Obtener el salario bruto de la fila
        const salarioBrutoInput = document.querySelector(`input[name="detalles[${filaIndex}][salario_bruto]"]`);
        
        const salarioBruto = parseFloat(salarioBrutoInput.value) || 0;
        console.log(salarioBruto);
        // Obtener el INSS Laboral de la fila
        const inssLaboralInput = document.querySelector(`input[name="detalles[${filaIndex}][inss_laboral]"]`);
        const inssLaboral = parseFloat(inssLaboralInput.value) || 0;

        // Realizar los cálculos de IR
        const salarioAjustado = salarioBruto - inssLaboral;
        console.log(salarioAjustado);
        const resultadoIRAnual = (((salarioAjustado * 12) - sobreExceso) * porcentaje)  + impuestoBase;
        console.log('ajustado ' + salarioAjustado);
        console.log('sobreexceso ' + sobreExceso);
        console.log('porcentaje ' + porcentaje);
        console.log(impuestoBase);
        const resultadoIRMensual = resultadoIRAnual / 12;
        console.log(resultadoIRMensual);
        // Asignar el resultado al input de IR de la fila
        const irInput = document.querySelector(`input[name="detalles[${filaIndex}][ir]"]`);
        irInput.value = resultadoIRMensual.toFixed(2);

        // Cerrar el modal
        cerrarModal();
    });

</script>


<script>

    function calcularDeducciones(index) {
        const inssLaboralInput = document.querySelector(`input[name="detalles[${index}][inss_laboral]"]`);
        const irInput = document.querySelector(`input[name="detalles[${index}][ir]"]`);

        const inssLaboral = parseFloat(inssLaboralInput.value) || 0;
        const ir = parseFloat(irInput.value) || 0;

        const totalDeducciones = inssLaboral + ir ;

        // Asignar el resultado al input de IR de la fila
        const deduccionesInput = document.querySelector(`input[name="detalles[${index}][total_deducciones]"]`);
        deduccionesInput.value = totalDeducciones.toFixed(2);

    }

    // Función para calcular el total de ingresos para todas las filas
    function calcularTotalParaTodasLasFilas() {
        const filas = document.querySelectorAll('#detalles-table tbody tr');
        filas.forEach((fila, index) => {
            calcularDeducciones(index);
        });
    }
    
    // Agregar listener al botón de cálculo
    document.getElementById('calcularDeduccionesBtn').addEventListener('click', calcularTotalParaTodasLasFilas);
</script>



<script>
        function calcularNetoRecibir(index) {

        
            const deduccionesInput = document.querySelector(`input[name="detalles[${index}][total_deducciones]"]`);
            const totalIngresosInput = document.querySelector(`input[name="detalles[${index}][total_ingresos]"]`);

            const deduccionesTotales = parseFloat(deduccionesInput.value) || 0;
            const ingresosTotales = parseFloat(totalIngresosInput.value) || 0;
            
            const netoRecibir =  ingresosTotales - deduccionesTotales;

            const netoRecibirInput = document.querySelector(`input[name="detalles[${index}][neto_recibir]"]`);
            netoRecibirInput.value = netoRecibir.toFixed(2);
        }

     // Función para calcular el total de ingresos para todas las filas
    function calcularTotalParaTodasLasFilas() {
        const filas = document.querySelectorAll('#detalles-table tbody tr');
        filas.forEach((fila, index) => {
            calcularNetoRecibir(index);
        });
    }

    // Agregar listener al botón de cálculo
    document.getElementById('calcularNetoRecibirBtn').addEventListener('click', calcularTotalParaTodasLasFilas);
</script>



<script>

const porcentajeSelect = document.querySelector('select[name="porcentajePatronal"]');
    // Función para calcular el porcentaje
    function calcularInssPatronal( index) {
        // Obtenemos los elementos por el atributo name
        const salarioBrutoInput = document.querySelector(`input[name="detalles[${index}][salario_bruto]"]`);
        
        const resultadoInput = document.querySelector(`input[name="detalles[${index}][inss_patronal]"]`);


        const salarioBruto = parseFloat(salarioBrutoInput.value) || 0;
        const porcentajePatronal = parseFloat(porcentajeSelect.value);

        // Realizamos el cálculo
        const resultado = salarioBruto * porcentajePatronal;

        // Mostramos el resultado en el input readonly
        resultadoInput.value = resultado.toFixed(2);
    }

    // Función para calcular el total de ingresos para todas las filas
    function calcularTotalParaTodasLasFilas() {
        const filas = document.querySelectorAll('#detalles-table tbody tr');
        filas.forEach((fila, index) => {
            calcularInssPatronal(index);
        });
    }

    // Escuchar eventos cuando cambie el valor del salario o el porcentaje
    //salarioBrutoInput.addEventListener('input', calcularTotalParaTodasLasFilas);
    porcentajeSelect.addEventListener('change', calcularTotalParaTodasLasFilas);
</script>
salari
<script>
    



    function calcularInatec( index) {

        const salarioBrutoInput = document.querySelector(`input[name="detalles[${index}][salario_bruto]"]`);
        const inatecInput = document.querySelector(`input[name="detalles[${index}][inatec]"]`);

        const salarioBruto = parseFloat(salarioBrutoInput.value) || 0;
        const inatec = parseFloat(porcentajeSelect.value);

        result = salarioBruto * 0.02;

        // Mostramos el resultado en el input readonly
        inatecInput.value = result.toFixed(2);
    }



    // Función para calcular el total de ingresos para todas las filas
    function calcularTotalParaTodasLasFilas() {
        const filas = document.querySelectorAll('#detalles-table tbody tr');
        filas.forEach((fila, index) => {
            calcularInatec(index);
        });
    }

    //salarioBrutoInput.addEventListener('input', calcularTotalParaTodasLasFilas);
    document.getElementById('calcularInatecBtn').addEventListener('click', calcularTotalParaTodasLasFilas);
</script>


<script>
    let filaIndex2 = null;  // Almacena el índice de la fila seleccionada

    // Función para abrir el modal de vacaciones y pasar el índice de la fila
    function abrirModalVacaciones(index) {
        filaIndex2 = index;
        document.getElementById('modalVacaciones').classList.remove('hidden');
    }

    // Función para cerrar el modal de vacaciones
    function cerrarModalVacaciones() {
        document.getElementById('modalVacaciones').classList.add('hidden');
    }

    // Función para calcular las vacaciones y asignar el resultado al input correspondiente de la fila
    document.getElementById('calcularVacacionesBtn').addEventListener('click', function () {
        event.preventDefault(); // Prevenir el comportamiento de envío del formulario
        const diasVacaciones = parseFloat(document.getElementById('diasVacaciones').value);

        // Obtener el salario bruto de la fila
        const salarioBrutoInput = document.querySelector(`input[name="detalles[${filaIndex2}][salario_bruto]"]`);
        const salarioBruto = parseFloat(salarioBrutoInput.value) || 0;

        if (isNaN(diasVacaciones) || isNaN(salarioBruto) || salarioBruto <= 0) {
            alert("Por favor, ingrese valores válidos.");
            return;
        }

        // Cálculos basados en el ejemplo proporcionado
        const valorDia = salarioBruto / 30;  // Paso 1
        const totalDiasVacaciones = diasVacaciones * (15 / 6);  // Paso 4
        const montoVacaciones = totalDiasVacaciones * valorDia;  // Vacaciones pagadas

        // Asignar el resultado al input de vacaciones de la fila correspondiente
        const vacacionesInput = document.querySelector(`input[name="detalles[${filaIndex2}][vacaciones]"]`);
        vacacionesInput.value = montoVacaciones.toFixed(2);

        // Cerrar el modal después de calcular
        cerrarModalVacaciones();
    });
</script>

<script>
    const mesesTrabajados = 5;  // Ejemplo de meses
    const diasTrabajados = 12;  // Ejemplo de días

    function calcularTreceavoMes( index) {
        const salarioBrutoInput = document.querySelector(`input[name="detalles[${index}][salario_bruto]"]`);
        const treceavoMesInput = document.querySelector(`input[name="detalles[${index}][treceavo_mes]"]`);

        const salarioBruto = parseFloat(salarioBrutoInput.value) || 0;
        

        // Cálculo del treceavo mes
        const parteMensual = salarioBruto / 12;
        const aguinaldoMeses = parteMensual * mesesTrabajados;
        const aguinaldoDias = (parteMensual / 30) * diasTrabajados;

        const totalAguinaldo = aguinaldoMeses + aguinaldoDias;

        // Mostramos el resultado en el input readonly
        treceavoMesInput.value = totalAguinaldo.toFixed(2);
    }

    // Función para calcular el total de ingresos para todas las filas
    function calcularTotalParaTodasLasFilas() {
        const filas = document.querySelectorAll('#detalles-table tbody tr');
        filas.forEach((fila, index) => {
            calcularTreceavoMes( index);
        });
    }


    //salarioBrutoInput.addEventListener('input', calcularTotalParaTodasLasFilas);
    document.getElementById('calcularTreceavoMesBtn').addEventListener('click', calcularTotalParaTodasLasFilas);
</script>


@endsection