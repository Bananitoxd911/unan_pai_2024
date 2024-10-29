
    <button onclick='openEditModal(@json($empleado))' class="font-medium text-blue-600 hover:underline">Editar</button>

<!-- Modal para editar empleado -->
<!-- Modal para editar empleado -->
<div id="editEmployeeModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900 bg-opacity-50">
    <div class="relative w-full max-w-lg md:max-w-2xl h-auto mx-auto">
        <!-- Contenido del Modal -->
        <div class="bg-white rounded-lg shadow-lg dark:bg-gray-800 max-h-[80vh] overflow-y-auto">
            <!-- Encabezado del modal -->
            <div class="flex items-start justify-between p-4 border-b border-gray-200 rounded-t dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Editar Empleado</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeEditModal()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Cuerpo del modal -->
            <div class="p-6 space-y-4">
                <form id="editEmployeeForm" action="{{route('empleados.update', $empleado->id)}}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_empleado" value="{{ $empresa->id }}">
                    <input type="hidden" id="input_id_empleado" name="id_empresa" value="{{$empleado->id}}" >

                    <!-- Campos de formulario -->
                    <div>
                        <label for="input_primer_nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Primer Nombre</label>
                        <input type="text" name="primer_nombre" id="input_primer_nombre" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    </div>
                    
                    <div>
                        <label for="input_segundo_nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Segundo Nombre</label>
                        <input type="text" name="segundo_nombre" id="input_segundo_nombre" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    </div>

                    <div>
                        <label for="input_primer_apellido" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Primer Apellido</label>
                        <input type="text" name="primer_apellido" id="input_primer_apellido" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    </div>

                    <div>
                        <label for="input_segundo_apellido" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Segundo Apellido</label>
                        <input type="text" name="segundo_apellido" id="input_segundo_apellido" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    </div>

                    <div>
                        <label for="input_numero_inss" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número INSS</label>
                        <input type="text" name="numero_inss" id="input_numero_inss" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    </div>

                    <div>
                        <label for="select_departamentocargo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departamento y Cargo</label>
                        <select name="departamentocargo_id" id="select_departamentocargo" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @foreach ($cargos as $cargo)
                                <option value="{{ $cargo->id }}">{{ $cargo->departamento->nombre }} - {{ $cargo->cargo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="input_antiguedad" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Antiguedad</label>
                        <input type="text" name="antiguedad" id="input_antiguedad" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    </div>

                    <div>
                        <label for="input_salario_bruto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Salario Bruto</label>
                        <input type="number" name="salario_bruto" id="input_salario_bruto" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    </div>

                    <!-- Botón para enviar -->
                    <div class="flex justify-end">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 dark:bg-blue-500 dark:hover:bg-blue-600">Actualizar Empleado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
