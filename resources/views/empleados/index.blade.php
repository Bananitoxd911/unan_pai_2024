@extends('layouts.nomina')

@section('contenido')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    
    <div class="flex items-center p-5 bg-white dark:bg-gray-800">
        <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo de {{ $empresa->nombre }}" class="h-12 w-12 mr-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $empresa->nombre }}</h2>
    </div>

    @include('empleados.partials.create')    
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Empleados
            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Lista de empleados registrados en la nómina de {{ $empresa->nombre }}. Puedes agregar, editar o eliminar empleados.</p>
        </caption>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Nombre</th>
                <th scope="col" class="px-6 py-3">Cargo</th>
                <th scope="col" class="px-6 py-3">Antiguedad</th>
                <th scope="col" class="px-6 py-3">Salario Bruto</th>
                <th scope="col" class="px-6 py-3 text-right"><span class="sr-only">Acciones</span></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $empleado)
                @if ($empleado->activo == 1)
                    @php
                        $nombre_completo = $empleado->primer_nombre . '  ' . $empleado->segundo_nombre . '  '. $empleado->primer_apellido . '  '. $empleado->segundo_nombre;
                    @endphp

                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $nombre_completo }}
                        </th>
                        <td class="px-6 py-4">{{ $empleado->departamentocargo->cargo->nombre }}</td>
                        <td class="px-6 py-4">{{ $empleado->antiguedad }}</td>
                        <td class="px-6 py-4">{{ number_format($empleado->salario_bruto, 2) }} C$</td>
                        <td class="px-6 py-4 text-right">
                            @include('empleados.partials.edit')

                            <form action="{{ route('empleados.destroy', ['empresa_id' => $empresa->id, 'empleado' => $empleado->id ]) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline ml-2">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                
                @endif

            @endforeach
        </tbody>
    </table>
</div>


<script>
    function openModal() {
        document.getElementById('addEmployeeModal').classList.remove('hidden');
        document.getElementById('modalOverlay').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('addEmployeeModal').classList.add('hidden');
        document.getElementById('modalOverlay').classList.add('hidden');
    }

    function openEditModal(empleado) {
        // Rellenar los campos del formulario en el modal
        document.getElementById('input_id_empleado').value = empleado.id;
        document.getElementById('input_primer_nombre').value = empleado.primer_nombre;
        document.getElementById('input_segundo_nombre').value = empleado.segundo_nombre;
        document.getElementById('input_primer_apellido').value = empleado.primer_apellido;
        document.getElementById('input_segundo_apellido').value = empleado.segundo_apellido;
        document.getElementById('input_numero_inss').value = empleado.numero_inss;
        document.getElementById('input_antiguedad').value = empleado.antiguedad;
        document.getElementById('input_salario_bruto').value = empleado.salario_bruto;

        // Rellenar el select del cargo
        const selectCargo = document.getElementById('select_departamentocargo');
        selectCargo.value = empleado.departamentocargo_id; // Asignar el cargo seleccionado

        // Abrir el modal
        document.getElementById('editEmployeeModal').classList.remove('hidden');
    }


    function closeEditModal() {
        document.getElementById('editEmployeeModal').classList.add('hidden');
        document.getElementById('modalOverlay').classList.add('hidden');
    }

    // Cerrar el modal si se hace clic en el overlay
    document.getElementById('modalOverlay').addEventListener('click', closeModal);
</script>

<script>
    function openCreateModalDepartamento() {
        document.getElementById('createDepartmentModal').classList.remove('hidden');
    }

    function closeCreateModalDepartamento() {
        document.getElementById('createDepartmentModal').classList.add('hidden');
    }
</script>



<script>
    function openModal() {
        document.getElementById("addEmployeeModal").classList.remove("hidden");
        document.getElementById("modalOverlay").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("addEmployeeModal").classList.add("hidden");
        document.getElementById("modalOverlay").classList.add("hidden");
    }

    document.getElementById('verificarInssBtn').addEventListener('click', function() {
    const numeroInss = document.getElementById('floating_numero_inss').value;

    // Mostrar el spinner de carga
    document.getElementById('loadingSpinner').classList.remove('hidden');

    // Realizar la verificación AJAX
    fetch(`/check-inss/${numeroInss}`)
        .then(response => response.json())
        .then(data => {
            // Ocultar el spinner de carga
            document.getElementById('loadingSpinner').classList.add('hidden');

            if (data.exists) {
                alert('El número de INSS ya existe. Intente con otro.');
            } else {
                // Si el INSS no existe, enviar el formulario
                document.getElementById('miFormulario').submit(); // Enviar el formulario
            }
        })
        .catch(error => {
            console.error('Error verificando el INSS:', error);
            // Ocultar el spinner si hay error
            document.getElementById('loadingSpinner').classList.add('hidden');
        });
});

</script>

@endsection
