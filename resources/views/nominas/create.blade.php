@extends('layouts.nomina')

@section('contenido')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Crear Nómina</h1>
    <form action="{{ route('nominas.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="empresa" class="block text-sm font-medium text-gray-700">Empresa</label>
            <input type="text" id="empresa" name="empresa" class="form-control mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm" value="{{ $empresa->nombre }}" readonly>
            <input type="hidden" name="id_empresa" value="{{ $empresaId }}">
        </div>
        <div class="mb-4">
            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
            <input type="date" id="fecha" name="fecha" class="form-control mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div class="mb-4">
            <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
            <input type="number" id="total" name="total" class="form-control mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm" step="0.01" required>
        </div>

        <h3 class="text-xl font-semibold mb-4">Detalles de Nómina</h3>
        <div class="overflow-x-auto">
            <table class="table-auto w-full border border-gray-300" id="detalles-table">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="px-4 py-2 border-b">Empleado</th>
                        <th class="px-4 py-2 border-b">Salario Bruto</th>
                        <th class="px-4 py-2 border-b">Horas Extra</th>
                        <th class="px-4 py-2 border-b">INSS Patronal</th>
                        <th class="px-4 py-2 border-b">Vacaciones</th>
                        <th class="px-4 py-2 border-b">13° Mes</th>
                        <th class="px-4 py-2 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-2">
                            <select name="detalles[0][id_empleado]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" required>
                                @foreach($empleados as $empleado)
                                    @php
                                        $nombre_completo = $empleado->primer
                                    @endphp
                                    <option value="{{ $empleado->id }}">{{ $nombre_completo }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-2"><input type="number" name="detalles[0][salario_bruto]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required></td>
                        <td class="px-4 py-2"><input type="number" name="detalles[0][cantidad_hrs_extra]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" required></td>
                        <td class="px-4 py-2"><input type="number" name="detalles[0][inss_patronal]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required></td>
                        <td class="px-4 py-2"><input type="number" name="detalles[0][vacaciones]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required></td>
                        <td class="px-4 py-2"><input type="number" name="detalles[0][treceavo_mes]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required></td>
                        <td class="px-4 py-2"><button type="button" class="btn btn-danger remove-row bg-red-500 text-white px-4 py-2 rounded-md">Eliminar</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button type="button" id="add-detail" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded-md">Agregar Detalle</button>
        <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Guardar</button>
    </form>
</div>

<script>
    document.getElementById('add-detail').addEventListener('click', function () {
        var tableBody = document.getElementById('detalles-table').querySelector('tbody');
        var index = tableBody.querySelectorAll('tr').length;
        var newRow = `
            <tr>
                <td class="px-4 py-2">
                    <select name="detalles[${index}][id_empleado]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" required>
                        @foreach($empleados as $empleado)
                            <option value="{{ $empleado->id }}">{{ $empleado->nombre_completo }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][salario_bruto]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][cantidad_hrs_extra]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" required></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][inss_patronal]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][vacaciones]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required></td>
                <td class="px-4 py-2"><input type="number" name="detalles[${index}][treceavo_mes]" class="form-control w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required></td>
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
@endsection
