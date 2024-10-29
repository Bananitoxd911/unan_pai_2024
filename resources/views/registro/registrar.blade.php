@extends('layouts.vacio')

@section('contenido')
<div class="w-full h-screen grid place-items-center justify-items-center">
    <form action="{{ route('registro.estudiante') }}" method="POST" class="font-[sans-serif] grid place-items-center max-w-7xl mx-auto">
        @csrf
        <h2 class="text-2xl font-bold mb-6">Registro de Estudiante</h2>
        <div class="grid sm:grid-cols-2 gap-6">
            
            <!-- Carnet -->
            <div class="relative flex items-center">
                <input type="text" name="carnet" value="{{ old('carnet') }}" placeholder="Carnet"
                    class="px-2 py-3 bg-white text-black w-full text-sm border-b-2 focus:border-[#007bff] outline-none" required />
                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2"
                    viewBox="0 0 24 24">
                    <path d="M20 4H4v16h16V4zm-2 14H6v-2h12v2zm0-4H6v-2h12v2zm0-4H6V8h12v2z" />
                </svg>
            </div>
            @error('carnet')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
            
            <!-- PIN -->
            <div class="relative flex items-center">
                <input id="pin" type="password" name="pin" placeholder="PIN"
                    class="px-2 py-3 bg-white text-black w-full text-sm border-b-2 focus:border-[#007bff] outline-none" required />
                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2 cursor-pointer" viewBox="0 0 128 128" id="togglePinVisibility">
                    <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" />
                </svg>
            </div>
            @error('pin')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
            
            <!-- Nombres -->
            <div class="relative flex items-center">
                <input type="text" name="nombres" value="{{ old('nombres') }}" placeholder="Nombres"
                    class="px-2 py-3 bg-white text-black w-full text-sm border-b-2 focus:border-[#007bff] outline-none" required />
                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2"
                    viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4 1.79 4 4s-1.79 4-4 4-4-1.79-4-4 1.79-4 4-4zm0-8C6.48 4 2 8.48 2 14c0 2.64 1.08 5.09 2.82 6.89L6 20.5v.5h12v-.5l1.18-1.6C20.92 19.09 22 16.64 22 14 22 8.48 17.52 4 12 4z" />
                </svg>
            </div>
            @error('nombres')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror

            <!-- Apellidos -->
            <div class="relative flex items-center">
                <input type="text" name="apellidos" value="{{ old('apellidos') }}" placeholder="Apellidos"
                    class="px-2 py-3 bg-white text-black w-full text-sm border-b-2 focus:border-[#007bff] outline-none" required />
                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2"
                    viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4 1.79 4 4s-1.79 4-4 4-4-1.79-4-4 1.79-4 4-4zm0-8C6.48 4 2 8.48 2 14c0 2.64 1.08 5.09 2.82 6.89L6 20.5v.5h12v-.5l1.18-1.6C20.92 19.09 22 16.64 22 14 22 8.48 17.52 4 12 4z" />
                </svg>
            </div>
            @error('apellidos')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror

        </div>
        
        <button type="submit"
            class="mt-10 px-6 py-2.5 w-full h-20 text-sm bg-blue-600 text-white hover:bg-blue-800 rounded-sm">Registrar Estudiante</button>
    </form>
</div>


<script>
    const togglePinVisibility = document.getElementById('togglePinVisibility');
    const pinInput = document.getElementById('pin');

    togglePinVisibility.addEventListener('click', function () {
        if (pinInput.type === 'password') {
            pinInput.type = 'text';
        } else {
            pinInput.type = 'password';
        }
    });
</script>
@endsection