@extends('layouts.nomina')


@section('contenido')
    <div class="flex items-center space-x-10 mb-10">
        <div>
            <img class="rounded-full w-48 h-48" src="{{asset('storage/' . $empresa->logo)}}" alt="image description">
        </div>
        <div>
            <h1 class=" text-6xl font-bold font-sans">Bienvenido a empresa {{$empresa->nombre}}</h1>
        </div>
        
    </div>


    <h2 class=" text-3xl font-semibold mb-8">Sistema de nominas</h2>

    <div class="flex flex-col gap-7">
        <a href="{{route('empleados.index', ['empresa_id' => $empresa->id])}}"><button>Empleados</button></a>

        <a href="{{route('nominas.index', ['empresa_id' => $empresa->id])}}"><button>Nomina</button></a>
    </div>

@endsection