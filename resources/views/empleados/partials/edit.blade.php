<button href="javascript:void(0);" onclick="openEditModal()" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</button>

<!-- Modal para editar empleado -->
<div id="editEmployeeModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto h-modal h-full">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Contenido del modal -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Encabezado del modal -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-end">
                    Editar Empleado
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeEditModal()">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Cuerpo del modal -->
            <div class="p-6 space-y-6">
                <form action="{{ route('empleados.update', $empleado->id) }}" method="POST" class="max-w-md mx-auto">
                    @csrf
                    @method('PUT') <!-- Método PUT para actualizar -->
                    
                <!-- Campo oculto para la empresa -->
                <input type="hidden" name="id_empresa" value="{{ $empresa->id }}">

                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="primer_nombre" id="floating_primer_nombre" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ old('primer_nombre', $empleado->primer_nombre) }}" required />
                    
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="segundo_nombre" id="floating_segundo_nombre" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ old('segundo_nombre', $empleado->segundo_nombre) }}" />
                    
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="primer_apellido" id="floating_primer_apellido" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ old('primer_apellido', $empleado->primer_apellido) }}" required />
                    
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="segundo_apellido" id="floating_segundo_apellido" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ old('segundo_apellido', $empleado->segundo_apellido) }}" />
                    
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="numero_inss" id="floating_numero_inss" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ old('numero_inss', $empleado->numero_inss) }}" required />
                    
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="cargo" id="floating_cargo" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ old('cargo', $empleado->cargo) }}" required />
                    
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input type="number" name="salario_bruto" id="floating_salario_bruto" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ old('salario_bruto', $empleado->salario_bruto) }}" required />
                    
                </div>


                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Actualizar Empleado
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>