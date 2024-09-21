@extends('layouts.nomina')

@section('contenido')
<div class="sm:mx-auto sm:w-full sm:max-w-md">
    <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
        Apertura de fondo fijo
    </h2>
</div>

<div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">

        <!-- Formulario para crear la apertura de fondo fijo -->
        <form action="{{ route('fondo_fijo.montoApertura') }}" method="POST">
            @csrf

            <!-- Campo oculto para la empresa:id -->
            <input type="hidden" name="id_empresa" value="{{ $empresa->id }}">

            <div class="mb-6">
                <label for="balance" class="block text-sm font-medium leading-5 text-gray-700">Monto</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="monto" name="monto" placeholder="monto en C$" type="number" value="{{ old('monto') }}" min="1" max="1000000" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                </div>
            </div>

            <div class="mb-6">
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Iterador para cuando no se cuente con suficiente dinero en banco para abastecer la caja chica. --}}
@if (Session::has('MontoBancoInsuficiente'))
        <script>
            Swal.fire({
                title: "¡Dinero insuficiente en banco!",
                icon: "error"
            });
        </script>
@endif

@endsection