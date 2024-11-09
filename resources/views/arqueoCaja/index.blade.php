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


<div class="grid grid-cols-6 w-full border border-gray-300 rounded-lg overflow-hidden">
    <!-- Encabezado de la tabla -->
    <div class="bg-gray-200 p-2 font-semibold text-center border border-gray-300">Denominaciones</div>
    <div class="bg-gray-200 p-2 font-semibold text-center border border-gray-300">Caja chica</div>
    <div class="bg-gray-200 p-2 font-semibold text-center border border-gray-300">Caja chica</div>
    <div class="bg-gray-200 p-2 font-semibold text-center border border-gray-300">Caja chica</div>
    <div class="bg-gray-200 p-2 font-semibold text-center border border-gray-300">Caja chica</div>
    <div class="bg-gray-200 p-2 font-semibold text-center border border-gray-300">Caja chica</div>

    <!-- Filas de la tabla -->
    <div class="p-2 text-center border border-gray-300 bg-gray-50">500</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>

    <div class="p-2 text-center border border-gray-300 bg-gray-50">200</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>

    <div class="p-2 text-center border border-gray-300 bg-gray-50">100</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>

    <div class="p-2 text-center border border-gray-300 bg-gray-50">50</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>

    <div class="p-2 text-center border border-gray-300 bg-gray-50">20</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>

    <div class="p-2 text-center border border-gray-300 bg-gray-50">10</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>

    <div class="p-2 text-center border border-gray-300 bg-gray-50">5</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>

    <div class="p-2 text-center border border-gray-300 bg-gray-50">1</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
    <div class="p-2 text-center border border-gray-300">0</div>
</div>



@endsection