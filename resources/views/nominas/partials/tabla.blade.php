
<table class="table-auto w-full border border-gray-300" id="detalles-table">
    <thead>
        <!-- Primera fila de encabezados (principales) -->
        <tr class="  text-white" style="background-color:#707DA5;">
            <th rowspan="2" class="px-4 py-2 border-b">No</th>
            <th rowspan="2" class="px-4 py-2 border-b">No INSS</th>
            <th rowspan="2" class="px-4 py-2 border-b">Nombre y Apellido</th>
            <th rowspan="2" class="px-4 py-2 border-b">Cargo</th>
            <th rowspan="2" class="px-4 py-2 border-b">Salario Bruto C$</th>
            <th rowspan="2" class="px-4 py-2 border-b">Cantidad de Horas Extras</th>
            <th rowspan="2" class="px-4 py-2 border-b">Horas Extras C$</th>
            <th colspan="3" class="px-4 py-2 border-b">Antigüedad</th>
            <th rowspan="2" class="px-4 py-2 border-b">
                Total Ingresos Devengados

            </th>
            <th colspan="2" class="px-4 py-2 border-b">Deducciones</th>
            <th rowspan="2" class="px-4 py-2 border-b">
                Total Deducciones
                

            </th>
            <th rowspan="2" class="px-4 py-2 border-b">
                Neto a Recibir
                
            </th>
            <th rowspan="2" class="px-4 py-2 border-b">
                INSS Patronal
                <!-- Select para los porcentajes -->
                <select id="porcentajePatronal" name="porcentajePatronal" class="form-select w-full py-2 px-4 dark:bg-slate-700 dark:text-white bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:border-teal-500 focus:ring focus:ring-teal-500 focus:border-teal-500 transition duration-200 ease-in-out">
                    <option value="0" selected>0</option>
                    <option value="0.215">21.5%</option>
                    <option value="0.225">22.5%</option>
                </select>

            </th>
            <th rowspan="2" class="px-4 py-2 border-b">
                INATEC
                <!-- Botón para calcular las deducciones -->
                
            </th>
            <th colspan="2" class="px-4 py-2 border-b">Prestaciones Sociales</th>
            <th rowspan="2" class="px-4 py-2 border-b">Acciones</th>
        </tr>
        <!-- Segunda fila de encabezados (subcampos) -->
        <tr class="  text-white" style="background-color: #95B2CC  ;">
            <th class="px-4 py-2 border-b">Años</th>
            <th class="px-4 py-2 border-b">Porcentaje</th>
            <th class="px-4 py-2 border-b">Monto C$</th>
            <th class="px-4 py-2 border-b">INSS Laboral</th>
            <th class="px-4 py-2 border-b">
                IR


            </th>
            <th class="px-4 py-2 border-b">Vacaciones</th>
            <th class="px-4 py-2 border-b">
                13° Mes
                <!-- Botón para calcular las deducciones -->
                
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="px-4 py-2 min-w-[100px]"><input type="number" name="detalles[0][numero]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" value="0"  readonly required ></td>
            <td class="px-4 py-2 min-w-[150px]">
                <input type="text" name="detalles[0][no_inss]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" value="" required readonly>
            </td>
            <td class="px-4 py-2 min-w-[200px]">

                <select name="detalles[0][empresaempleado_id]" class="form-control dark:bg-slate-700 dark:text-white  min-w-[300px] py-2 px-3 bg-gray-100 border border-gray-300 rounded-md empleado-select" required>
                    <option value="">Seleccione un empleado</option>
                    @foreach($empleados as $empleado)
                        
                        @php
                            $nombre_completo = $empleado->primer_nombre . " " . $empleado->segundo_nombre . " " . $empleado->primer_apellido . " " . $empleado->segundo_apellido;
                            $antiguedad = $empleado->antiguedad;
                        @endphp
                        <option value="{{ $empleado->id }}"
                                data-no-inss="{{ $empleado->numero_inss }}"
                                data-cargo-id="{{ $empleado->departamentocargo->cargo_id }}"
                                data-cargo="{{ $empleado->departamentocargo->cargo->nombre }}"
                                data-salario="{{ $empleado->salario_bruto }}"
                                data-antiguedad-ano="{{ $antiguedad}}">
                                
                            {{ $nombre_completo }}
                        </option>
                    @endforeach
                </select>

            </td>
            <td class="px-4 py-2 min-w-[250px]">
                <input type="text" name="detalles[0][cargo]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" value="" required readonly>
            </td>
            <td class="px-4 py-2 min-w-[150px]">
                <input type="number" name="detalles[0][salario_bruto]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" value="" required readonly>
            </td>
            <td class="px-4 py-2 min-w-[150px]"><input type="number" name="detalles[0][cantidad_hrs_extra]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" required></td>
            <td class="px-4 py-2 min-w-[150px]"><input type="number" name="detalles[0][hrs_extra_c]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" value="" required readonly></td>
            <td class="px-4 py-2 min-w-[100px]"><input type="number" name="detalles[0][antiguedad_anos]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" required readonly></td>
            <td class="px-4 py-2 min-w-[100px]"><input type="number" name="detalles[0][antiguedad_porcentaje]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required></td>
            <td class="px-4 py-2 min-w-[150px]"><input type="number" name="detalles[0][antiguedad_monto]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required readonly></td>
            <td class="px-4 py-2 min-w-[180px]">
                <div class="relative flex items-center">
                    <input type="number" name="detalles[0][total_ingresos]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md pr-12" step="0.01" required readonly>
                    <button type="button"  class="calcularTotal absolute right-0 mr-1 px-4 py-2 bg-orange-400 text-white rounded-md" data-index="0">C</button>
                </div>
            </td>

            <td class="px-4 py-2 min-w-[150px]"><input type="number" name="detalles[0][inss_laboral]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required readonly></td>
            <td class="px-4 py-2 min-w-[180px]">
                <div class="relative flex items-center">
                    <input type="number" name="detalles[0][ir]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required readonly>
                    @include('nominas.partials.modal_ir')
                </div>

            </td>
            <td class="px-4 py-2 min-w-[150px]">
                <div class="relative flex items-center">
                    <input type="number" name="detalles[0][total_deducciones]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required readonly>
                    <button type="button" class="calcularDeduccionesBtn absolute right-0 mr-1 px-4 py-2 bg-orange-400 text-white rounded-md" data-index="0">C</button>

                </div>
                
            </td>
            <td class="px-4 py-2 min-w-[150px]">
                <div class="relative flex items-center">
                    <input type="number" name="detalles[0][neto_recibir]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required readonly>
                    <button type="button" class="calcularNetoRecibirBtn absolute right-0 mr-1 px-4 py-2 bg-orange-400 text-white rounded-md" data-index="0">C</button>

                </div>    
                
            
            </td>
            <td class="px-4 py-2 min-w-[180px]">

            <div class="relative flex items-center">
                <input type="number" name="detalles[0][inss_patronal]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required readonly>
                <button type="button" class="calcularInssPatronalBtn absolute right-0 mr-1 px-4 py-2 bg-orange-400 text-white rounded-md" data-index="0">C</button>
            </div>
            
            </td>
            <td class="px-4 py-2 min-w-[150px]">
                <div class="relative flex items-center">
                    <input type="number" name="detalles[0][inatec]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required readonly>
                    <button type="button" class="calcularInatecBtn absolute right-0 mr-1 px-4 py-2 bg-orange-400 text-white rounded-md" data-index="0">C</button>

                </div>

            </td>
            <td class="px-4 py-2 min-w-[150px]">
                <div class="relative flex items-center">
                    <input type="number" name="detalles[0][vacaciones]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required readonly>
                    @include('nominas.partials.modal_vacaciones')
                </div>
            </td>
            <td class="px-4 py-2 min-w-[180px]">

                <div class="relative flex items-center">
                    <input type="number" name="detalles[0][treceavo_mes]" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required readonly>
                    <button type="button" class="calcularTreceavoMesBtn absolute right-0 mr-1 px-4 py-2 bg-orange-400 text-white rounded-md" data-index="0">C</button>
                </div>
            </td>
            <td class="px-4 py-2"><button type="button" class="btn btn-danger remove-row bg-blue-700 text-white px-4 py-2 rounded-md">Eliminar</button></td>
        </tr>
    </tbody>
</table>


