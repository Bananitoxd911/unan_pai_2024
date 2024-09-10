@extends('layouts.nomina')

@section('contenido')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <!-- Logo y Nombre de la Empresa -->
    <div class="flex items-center p-5 bg-white dark:bg-gray-800">
        <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo de {{ $empresa->nombre }}" class="h-12 w-12 mr-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $empresa->nombre }}</h2>
    </div>

    <!-- Botón para abrir el modal (Agregar/Editar) -->
    <button onclick="openModal()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Agregar Empleado</button>

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Empleados
            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Lista de empleados registrados en la nómina de {{ $empresa->nombre }}. Puedes agregar, editar o eliminar empleados.</p>
        </caption>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Nombre</th>
                <th scope="col" class="px-6 py-3">Cargo</th>
                <th scope="col" class="px-6 py-3">Salario Bruto</th>
                <th scope="col" class="px-6 py-3 text-right"><span class="sr-only">Acciones</span></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $empleado)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $empleado->primer_nombre }} {{ $empleado->primer_apellido }}
                    </th>
                    <td class="px-6 py-4">{{ $empleado->cargo }}</td>
                    <td class="px-6 py-4">C$ {{ number_format($empleado->salario_bruto, 2) }} </td>
                    <td class="px-6 py-4 text-right">
                        <!-- Botón para abrir el modal (Editar) -->
                        <button onclick="openModal({{ $empleado->id }})" type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</button>
                        <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline ml-2">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Overlay -->
<div id="modalOverlay" class="fixed inset-0 z-40 hidden bg-gray-900 bg-opacity-50"></div>

    <!-- Modal -->
    <div id="empleadoModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex items-center justify-center hidden overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
        <div class="relative w-full max-w-lg p-4 bg-white rounded-lg shadow-lg dark:bg-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white">
                    Agregar Empleado
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeModal()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9.293l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414L10 8.586z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <!-- Formulario para agregar empleado -->
            <form id="empleadoForm" action="{{ route('empleados.store') }}" method="POST" class="max-w-md mx-auto">
                @csrf
                <!-- Campo oculto para la empresa -->
                <input type="hidden" name="id_empresa" value="{{ $empresa->id }}">

                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="primer_nombre" id="floating_primer_nombre" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ old('primer_nombre') }}" required />
                    <label for="floating_primer_nombre" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Primer Nombre</label>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="segundo_nombre" id="floating_segundo_nombre" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ old('segundo_nombre') }}" />
                    <label for="floating_segundo_nombre" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Segundo Nombre</label>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="primer_apellido" id="floating_primer_apellido" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ old('primer_apellido') }}" required />
                    <label for="floating_primer_apellido" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Primer Apellido</label>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="segundo_apellido" id="floating_segundo_apellido" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ old('segundo_apellido') }}" />
                    <label for="floating_segundo_apellido" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Segundo Apellido</label>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="numero_inss" id="floating_numero_inss" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ old('numero_inss') }}" required />
                    <label for="floating_numero_inss" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Número INSS</label>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="cargo" id="floating_cargo" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ old('cargo') }}" required />
                    <label for="floating_cargo" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cargo</label>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input type="number" name="salario_bruto" id="floating_salario_bruto" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ old('salario_bruto') }}" required />
                    <label for="floating_salario_bruto" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Salario Bruto</label>
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 mr-2 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-600 dark:hover:border-gray-600 dark:focus:ring-gray-600">Cancelar</button>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar</button>
                </div>
            </form>
        </div>
    </div>

<script>
    function openModal(id = null) {
        const modal = document.getElementById('empleadoModal');
        const overlay = document.getElementById('modalOverlay');

        modal.classList.remove('hidden');
        overlay.classList.remove('hidden');

        if (id) {
    // Aquí puedes cargar los datos del empleado en el formulario usando AJAX si es necesario
    document.getElementById('modalTitle').textContent = "Editar Empleado";
    
    // Ejemplo de lógica para cargar los datos en el formulario usando AJAX
    fetch(`/empleados/${id}`)
        .then(response => response.json())
        .then(data => {
            document.querySelector('input[name="primer_nombre"]').value = data.primer_nombre;
            document.querySelector('input[name="segundo_nombre"]').value = data.segundo_nombre;
            document.querySelector('input[name="primer_apellido"]').value = data.primer_apellido;
            document.querySelector('input[name="segundo_apellido"]').value = data.segundo_apellido;
            document.querySelector('input[name="numero_inss"]').value = data.numero_inss;
            document.querySelector('input[name="cargo"]').value = data.cargo;
            document.querySelector('input[name="salario_bruto"]').value = data.salario_bruto;
            
            // Puedes añadir más campos si es necesario
        })
        .catch(error => {
            console.error('Error al cargar los datos del empleado:', error);
        });
} else {
    document.getElementById('modalTitle').textContent = "Agregar Empleado";
    // Limpiar el formulario
    document.getElementById('empleadoForm').reset();
}
    }

    function closeModal() {
        const modal = document.getElementById('empleadoModal');
        const overlay = document.getElementById('modalOverlay');

        modal.classList.add('hidden');
        overlay.classList.add('hidden');
    }

    // Cerrar el modal cuando se hace clic en el overlay
    document.getElementById('modalOverlay').addEventListener('click', closeModal);
</script>
@endsection
