@extends('layouts.nomina')

@section('contenido')

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Banco
            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Cuentas bancarias de la empresa: {{ $empresa->nombre }}.</p>
        </caption>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Fecha</th>
                <th scope="col" class="px-6 py-3">Número de Cuenta</th>
                <th scope="col" class="px-6 py-3">Balance en C$</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cuentas as $cuenta)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $cuenta->created_at }}</td>
                    <td class="px-6 py-4">{{ $cuenta->numero_de_cuenta }}</td>
                    <td class="px-6 py-4">{{ number_format($cuenta->balance, 2) }} C$</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection