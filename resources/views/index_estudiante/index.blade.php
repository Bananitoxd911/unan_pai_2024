@extends('layouts.nomina')

@section('contenido')
<style>
    .corporate-card {
        background: linear-gradient(135deg, #4c6ef5, #20c997);
        color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        padding: 20px;
        text-align: center;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .corporate-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .table-header {
        background-color: #4c6ef5;
        color: white;
        font-weight: bold;
    }

    .table-row:hover {
        background-color: #f1f5f9;
    }

    .btn-primary {
        background-color: #4c6ef5;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #3b5bdb;
    }
</style>

<div class="container mx-auto px-6 py-6">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold">Bienvenido a {{ $empresa->nombre }}</h1>
        <p class="text-lg text-gray-600 mt-2">Gestión integral de empleados y nóminas</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Empleados -->
        <div class="corporate-card">
            <h2 class="text-2xl font-bold mb-4">Empleados Registrados</h2>
            <p class="text-sm mb-6">Administra los empleados activos de la empresa.</p>
            <a href="{{ route('empleados.index', ['empresa_id' => $empresa->id]) }}" class="btn-primary">
                Ver Todos los Empleados
            </a>
        </div>

        <!-- Nóminas -->
        <div class="corporate-card">
            <h2 class="text-2xl font-bold mb-4">Nóminas Vigentes</h2>
            <p class="text-sm mb-6">Revisa y gestiona las nóminas existentes.</p>
            <a href="{{ route('nominas.index', ['empresa_id' => $empresa->id]) }}" class="btn-primary">
                Ver Nóminas
            </a>
        </div>
    </div>

    <!-- Tablas Detalladas -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-4">Detalle de Empleados</h2>
        <table class="min-w-full bg-white border border-gray-200 rounded-md shadow-md mb-8">
            <thead class="table-header">
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Cargo</th>
                    <th class="px-4 py-2">Antigüedad</th>
                    <th class="px-4 py-2">Salario Bruto</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($empleados as $empleado)
                    <tr class="table-row text-center">
                        <td class="px-4 py-2">{{ $empleado->primer_nombre }} {{ $empleado->primer_apellido }}</td>
                        <td class="px-4 py-2">{{ $empleado->departamentocargo->cargo->nombre }}</td>
                        <td class="px-4 py-2">{{ $empleado->antiguedad }}</td>
                        <td class="px-4 py-2">{{ number_format($empleado->salario_bruto, 2) }} C$</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('empleados.edit', $empleado->id) }}" class="text-blue-500">Editar</a>
                            |
                            <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="text-2xl font-bold mb-4">Detalle de Nóminas</h2>
        <table class="min-w-full bg-white border border-gray-200 rounded-md shadow-md">
            <thead class="table-header">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Empresa</th>
                    <th class="px-4 py-2">Fecha</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nominas as $nomina)
                    <tr class="table-row text-center">
                        <td class="px-4 py-2">{{ $nomina->id }}</td>
                        <td class="px-4 py-2">{{ $nomina->empresa->nombre }}</td>
                        <td class="px-4 py-2">{{ $nomina->fecha }}</td>
                        <td class="px-4 py-2">{{ number_format($nomina->total, 2) }} C$</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('nominas.show', $nomina->id) }}" class="text-blue-500">Ver</a>
                            |
                            <form action="{{ route('nominas.destroy', $nomina->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
