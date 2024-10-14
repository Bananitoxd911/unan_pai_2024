@extends('layouts.nomina')

@section('contenido')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <!-- Logo y Nombre de la Empresa -->
    <div class="flex items-center p-5 bg-white dark:bg-gray-800">
        <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo de {{ $empresa->nombre }}" class="h-12 w-12 mr-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $empresa->nombre }}</h2>
    </div>

    <a href="{{ route('informes.empleados', ['empresa_id' => $empresa->id]) }}">
        Ver Informe de Ingresos
    </a>

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
                <th scope="col" class="px-6 py-3">Salario Bruto</th>
                <th scope="col" class="px-6 py-3 text-right"><span class="sr-only">Acciones</span></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $empleado)
                @php
                    $nombre_completo = $empleado->primer_nombre . '  ' . $empleado->segundo_nombre . '  '. $empleado->primer_apellido . '  '. $empleado->segundo_nombre;
                @endphp

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $nombre_completo }}
                    </th>
                    <td class="px-6 py-4">{{ $empleado->cargo }}</td>
                    <td class="px-6 py-4">{{ number_format($empleado->salario_bruto, 2) }} C$</td>
                    <td class="px-6 py-4 text-right">
                        @include('empleados.partials.edit')

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


<script>
    function openModal() {
        document.getElementById('addEmployeeModal').classList.remove('hidden');
        document.getElementById('modalOverlay').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('addEmployeeModal').classList.add('hidden');
        document.getElementById('modalOverlay').classList.add('hidden');
    }

    function openEditModal() {
        document.getElementById('editEmployeeModal').classList.remove('hidden');
        document.getElementById('modalOverlay').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editEmployeeModal').classList.add('hidden');
        document.getElementById('modalOverlay').classList.add('hidden');
    }

    // Cerrar el modal si se hace clic en el overlay
    document.getElementById('modalOverlay').addEventListener('click', closeModal);
</script>

@endsection
