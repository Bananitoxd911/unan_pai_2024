@extends('layouts.principal')

@section('contenido')

<div class="w-full h-screen grid grid-cols-1 md:grid-cols-2">

    <!-- Botón que redirige a la vista del login del profesor -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 flex flex-col justify-center items-center">
        <a href="{{ route('login.profesor') }}">
            <button class="bg-white text-gray-800 font-bold p-6 rounded-lg shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <p class="text-3xl">Profesor</p>    
            </button>
        </a>
    </div>

    <!-- Botón que redirige a la vista del login del estudiante -->
    <div class="bg-gradient-to-r from-green-400 to-teal-500 flex flex-col justify-center items-center">
        <a href="{{ route('login.estudiante') }}">
            <button class="bg-white text-gray-800 font-bold p-6 rounded-lg shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <p class="text-3xl">Estudiante</p>    
            </button>
        </a>
    </div>

</div>

@endsection
