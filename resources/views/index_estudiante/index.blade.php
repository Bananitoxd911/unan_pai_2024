@extends('layouts.nomina')


@section('contenido')
<style>
    .material-symbols-outlined {
        font-size: 50px !important;
    }
</style>
    <div class="flex items-center space-x-10 mb-10">
        <div>
            <img class="rounded-full w-48 h-48" src="{{asset('storage/' . $empresa->logo)}}" alt="image description">
        </div>
        <div>
            <h1 class=" text-6xl font-bold font-sans">Bienvenido a empresa {{$empresa->nombre}}</h1>
        </div>
        
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-7 justify-items-center">

        <a href="{{route('empleados.index', ['empresa_id' => $empresa->id])}}" >
            <button class=" grid grid-cols-1 middle none center mr-4 rounded-lg bg-blue-500 p-24 font-sans text-xl font-extrabold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                <span class="material-symbols-outlined">
                    groups
                </span>
                Empleados

            </button>
        </a>

        

        <a href="{{route('nominas.index', ['empresa_id' => $empresa->id])}}">
            <button class=" grid grid-cols-1  middle none center mr-4 rounded-lg bg-green-500 p-24 font-sans font-extrabold text-xl  uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                <span class="material-symbols-outlined font">
                    web
                </span>
                Nomina
            </button>
        </a>
    </div>

@endsection