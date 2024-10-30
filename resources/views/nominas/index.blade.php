@extends('layouts.nomina')

@section('contenido')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Lista de Nóminas de {{ $empresa->nombre }}</h1>
        <a href="{{ route('nominas.create', ['empresa_id' => $empresa->id]) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Crear Nueva Nómina</a>
        @if($nominas->count())
            <table class="min-w-full bg-white mt-6 border border-gray-200 rounded-md shadow-md">
                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th class="px-4 py-2 border-b">ID</th>
                        <th class="px-4 py-2 border-b">Empresa</th>
                        <th class="px-4 py-2 border-b">Fecha</th>
                        <th class="px-4 py-2 border-b">Total</th>
                        <th class="px-4 py-2 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nominas as $nomina)
                        <tr class="hover:bg-gray-50  text-center dark:bg-gray-700 dark:hover:bg-gray-600">
                            <td class="px-4 py-2 border-b">{{ $nomina->id }}</td>
                            <td class="px-4 py-2 border-b">{{ $nomina->empresa->nombre }}</td>
                            <td class="px-4 py-2 border-b">{{ $nomina->nomina->fecha }}</td>
                            <td class="px-4 py-2 border-b">{{ number_format($nomina->nomina->total, 2) }}</td>
                            <td class="px-4 py-2 border-b">
                            <a href="{{ route('nominas.show', ['nomina' => $nomina->nomina->id, 'empresa' => $empresa->id]) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Ver</a>


                                

                                <form action="{{ route('nominas.destroy', $nomina->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600" onclick="return confirm('¿Estás seguro de que quieres eliminar esta nómina?');">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <p class="text-gray-500 mt-4">No hay nóminas disponibles para esta empresa.</p>
        @endif
    </div>
@endsection