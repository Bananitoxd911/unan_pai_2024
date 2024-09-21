@extends('layouts.nomina')

@section('contenido')
<div class="sm:mx-auto sm:w-full sm:max-w-md">
    <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
        Nueva Cuenta En Banco
    </h2>
</div>

<div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">

        <!-- Formulario para crear una nueva empresa -->
        <form action="{{ route('banco.store') }}" method="POST">
            @csrf

            <!-- Campo oculto para la empresa -->
            <input type="hidden" name="id_empresa" value="{{ $empresa->id }}">

            <div class="mb-6">
                <label for="nCuenta" class="block text-sm font-medium leading-5 text-gray-700">Cuenta {{ e('(6 dígitos)') }}</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="nCuenta" name="nCuenta" placeholder="Número de cuenta" type="text" pattern="\d{6}" title="La cuenta consta de 6 dígitos numéricos sin espacios." value="{{ old('nCuenta') }}" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                </div>
            </div>

            <div class="mb-6">
                <label for="balance" class="block text-sm font-medium leading-5 text-gray-700">Balance</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="balance" name="balance" placeholder="Saldo de la cuenta en C$" type="number" value="{{ old('balance') }}" min="1" max="1000000" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                </div>
            </div>

            <div class="mb-6">
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out">
                    Crear Cuenta
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Iterador para cuando no se encuentre una empresa para la operación --}}
@if (Session::has('no_empresa'))
        <script>
            Swal.fire({
                title: "Empresa no encontrada",
                icon: "error"
            });
        </script>
@endif

{{-- Iterador para cuando se encuentre un número de cuenta duplicado --}}
@if (Session::has('cuentaExiste'))
        <script>
            Swal.fire({
                title: "El número de cuenta ya existe",
                icon: "error"
            });
        </script>
@endif

@endsection