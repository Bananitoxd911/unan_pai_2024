@extends('layouts.principal')

@section('contenido')

<div class="font-[sans-serif]">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="grid md:grid-cols-2 items-center gap-4 max-md:gap-8 max-w-6xl max-md:max-w-lg w-full p-4 m-4 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md">
        <div class="md:max-w-md w-full px-4 py-4">
            <form action="{{ route('inicio.estudiante') }}" method="POST">
            @csrf
            <div class="mb-12">
                <h3 class="text-gray-800 text-2xl font-extrabold dark:text-white">Inicio de Sesión Estudiante</h3>
                <p class="text-sm mt-4 text-gray-800 dark:text-white">¿No tienes una cuenta? <a href="{{route('registro')}}" class="text-blue-600 font-semibold hover:underline ml-1 whitespace-nowrap">Regístrate aquí</a></p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-200 text-red-700 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </div>
            @endif

            <div>
                <label for="carnet" class="text-gray-800 text-xs block mb-2">Carnet</label>
                <div class="relative flex items-center">
                <input name="carnet" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Ingrese su carnet" />
                </div>
            </div>

            <div class="mt-8">
                <label for="pin" class="text-gray-800 text-xs block mb-2">PIN</label>
                <div class="relative flex items-center">
                    <input id="pin" name="pin" type="password" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Ingrese su PIN" />
                    <button type="button" onclick="togglePIN()" class="absolute right-2">
                    <span class="material-symbols-outlined" id="eyeIcon">
                    visibility
                    </span>
                    </button>
                </div>
            </div>

            <div class="mt-12">
                <button type="submit" class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                Ingresar
                </button>
            </div>
            </form>
        </div>

        <div class="md:h-full bg-slate-400 rounded-xl lg:p-12 p-8">
            <img src="{{ asset('assets/logo=unan.png') }}" class="w-full h-full object-contain" alt="login-image" />
        </div>
        </div>
    </div>
    </div>


    <script>
    function togglePIN() {
        const pinInput = document.getElementById('pin');
        const eyeIcon = document.getElementById('eyeIcon');

        if (pinInput.type === 'password') {
            pinInput.type = 'text';
            eyeIcon.innerHTML = '<span class="material-symbols-outlined">visibility</span>';
        } else {
            pinInput.type = 'password';
            eyeIcon.innerHTML = '<span class="material-symbols-outlined">visibility_off</span>';
        }
    }
</script>

@endsection
