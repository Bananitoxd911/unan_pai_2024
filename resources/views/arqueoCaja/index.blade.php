@extends('layouts.arqueo')

@section('contenido')
<div class="grid grid-cols-2 gap-6 p-4 bg-gray-100 rounded-lg shadow-lg w-full">
    <!-- Sección Banco -->
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <p class="text-3xl font-semibold text-blue-600 mb-4">Banco</p>
        
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg shadow-sm border border-blue-200">
                <p class="text-xl font-semibold text-blue-700">Cuenta 1</p>
                <p class="text-gray-700">Saldo: <span class="font-semibold">C$ 0.00</span></p>
            </div>
            
            <div class="bg-blue-50 p-4 rounded-lg shadow-sm border border-blue-200">
                <p class="text-xl font-semibold text-blue-700">Cuenta 2</p>
                <p class="text-gray-700">Saldo: <span class="font-semibold">C$ 0.00</span></p>
            </div>
        </div>
    </div>

    <!-- Sección Caja General -->
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <p class="text-3xl font-semibold text-green-600 mb-4">Caja General</p>
        <p class="text-gray-700 text-xl">Saldo: <span class="font-semibold">C$ 0.00</span></p>
    </div>
</div>


@include('arqueoCaja.partials.mostrar.tabs')



@endsection