@extends('layouts.principal')

@section('contenido')

<div class="font-[sans-serif]">
  <div class="min-h-screen flex flex-col items-center justify-center">
    <div class="grid md:grid-cols-2 items-center gap-4 max-md:gap-8 max-w-6xl max-md:max-w-lg w-full p-4 m-4 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md">
      <div class="md:max-w-md w-full px-4 py-4">
        <form action="{{ route('login.profesor') }}" method="POST">
          @csrf
          <div class="mb-12">
            <h3 class="text-gray-800 text-3xl font-extrabold">Inicio de Sesión Profesor</h3>
            
          </div>

          <div>
            <label for="nombres" class="text-gray-800 text-xs block mb-2">Nombres</label>
            <div class="relative flex items-center">
              <input name="nombres" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Ingresa tus nombres" />
              <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2" viewBox="0 0 682.667 682.667">
                <!-- SVG del ícono de usuario -->
              </svg>
            </div>
          </div>

          <div class="mt-8">
            <label for="contrasena" class="text-gray-800 text-xs block mb-2">Contraseña</label>
            <div class="relative flex items-center">
              <input name="contrasena" type="password" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Ingresa tu contraseña" />
              <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2 cursor-pointer" viewBox="0 0 128 128">
                <!-- SVG del ícono de contraseña -->
              </svg>
            </div>
          </div>


          <div class="mt-12">
            <button type="submit" class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">Ingresar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

