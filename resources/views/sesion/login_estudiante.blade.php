@extends('layouts.principal')

@section('contenido')

<div class="font-[sans-serif]">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="grid md:grid-cols-2 items-center gap-4 max-md:gap-8 max-w-6xl max-md:max-w-lg w-full p-4 m-4 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md">
        <div class="md:max-w-md w-full px-4 py-4">
            <form action="{{ route('inicio.estudiante') }}" method="POST">
            @csrf
            <div class="mb-12">
                <h3 class="text-gray-800 text-2xl font-extrabold">Inicio de Sesión Estudiante</h3>
                <p class="text-sm mt-4 text-gray-800">¿No tienes una cuenta? <a href="{{route('registro')}}" class="text-blue-600 font-semibold hover:underline ml-1 whitespace-nowrap">Regístrate aquí</a></p>
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
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-6.66-1.41A9 9 0 003 12a9 9 0 0014.66 1.41M19.07 4.93A10.97 10.97 0 0121 12a10.97 10.97 0 01-1.93 7.07M4.93 4.93A10.97 10.97 0 003 12a10.97 10.97 0 001.93 7.07" />
                        </svg>
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

        <div class="md:h-full bg-[#000842] rounded-xl lg:p-12 p-8">
            <img src="https://readymadeui.com/signin-image.webp" class="w-full h-full object-contain" alt="login-image" />
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
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825a3 3 0 00-3.75 0M15.218 4.875A9.005 9.005 0 013 12c0 2.395.896 4.577 2.375 6.218M19.824 12.073A9 9 0 0112 3.216M9.94 9.94l1.06 1.06M9.88 9.88l1.06 1.06" />';
            } else {
                pinInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-6.66-1.41A9 9 0 003 12a9 9 0 0014.66 1.41M19.07 4.93A10.97 10.97 0 0121 12a10.97 10.97 0 01-1.93 7.07M4.93 4.93A10.97 10.97 0 003 12a10.97 10.97 0 001.93 7.07" />';
            }
        }
    </script>
@endsection
