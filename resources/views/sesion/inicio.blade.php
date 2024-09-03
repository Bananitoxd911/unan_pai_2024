@extends('layouts.principal')

@section('contenido')

    <div class=" w-full grid grid-cols-1 md:grid-cols-2 h-screen">

    
        <!--Boton que redirige a la vista del login del profesor -->
        <div class=" bg-slate-500 grid h-full w-full justify-items-center place-items-center">
            <a href="{{route('login.profesor')}}">
                <button class=" bg-blue-600 p-12 rounded-lg ">
                    <p class=" text-white">
                        Profesor
                    </p>    
                </button>
            </a>
        </div>


        <!--Boton que redirige a la vista del login del estudiante -->
        <div class=" bg-black h-full w-full grid justify-items-center place-items-center">
            <a href="{{route('login.estudiante')}}">
                <button class=" bg-yellow-600 p-12 rounded-lg " >
                    <p class=" text-white">
                        Estudiante
                    </p>    
                </button>
            </a>

        </div >
    </div>

@endsection