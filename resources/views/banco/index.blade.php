@extends('layouts.nomina')

@section('contenido')

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Banco
            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Cuenta bancaria de la empresa: {{ $empresa->nombre }}.</p>
        </caption>
        <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Su numero de cuenta es cuenta es: {{ $numero_cuenta }}
        </caption>
        <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Usted tiene {{ number_format($cuenta_actual) }} C$ en su cuenta
        </caption>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Fecha</th>
                <th scope="col" class="px-6 py-3">operación</th>
                <th scope="col" class="px-6 py-3">Balance en C$</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cuentas as $cuenta)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $cuenta->created_at->format('d-m-Y') }}</td>
                    <td class="px-6 py-4">{{ $cuenta->operacion }}</td>
                    <td class="px-6 py-4">{{ number_format($cuenta->balance, 2) }} C$</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Iterador para cuando se crea la cuenta en el banco correctamente --}}
@if (Session::has('cuentaBancoCreada'))
        <script>
            Swal.fire({
                title: "Cuenta de banco creada correctamente",
                icon: "success"
            });
        </script>
@endif

@endsection