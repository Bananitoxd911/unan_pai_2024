<button href="javascript:void(0);" onclick="openCreateModalDepartamento()" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Nuevo Departamento</button>

<!-- Modal para crear departamento -->
<div id="createDepartmentModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto h-modal h-full bg-black bg-opacity-50">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Contenido del modal -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Encabezado del modal -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-end">
                    Agregar Departamento
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeCreateModalDepartamento()">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Cuerpo del modal -->
            <div class="p-6 space-y-6">
                <form action="{{ route('departamentos.store') }}" method="POST" class="max-w-md mx-auto">
                    @csrf
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="nombre" id="floating_nombre" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_nombre" class="peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-1.5 peer-placeholder-shown:text-gray-500">Nombre del Departamento</label>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Crear Departamento
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
