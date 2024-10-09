@extends('layouts.principal')

@section('contenido')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <a href="{{ route('empresas.create') }}">
        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-4 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Agregar Nueva Empresa
        </button>
    </a>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 justify-items-center">
        @foreach($empresas as $empresa)
            <div class="w-full max-w-xs bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="#">
                    <img class="rounded-t-lg w-full h-40 object-contain" src="{{ asset('storage/' . $empresa->logo) }}" alt="{{ $empresa->nombre }}" />
                </a>
                <div class="p-5">
                    <a href="#">
                        <h5 class="mb-2 text-xl text-center font-bold tracking-tight text-gray-900 dark:text-white">{{ $empresa->nombre }}</h5>
                    </a>
                    <div class="grid grid-cols-1 gap-2 mt-4 md:grid-cols-2 w-full justify-items-center">
                        <a href="{{route('index.estudiante', ['empresa_id' => $empresa->id])}}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Ver más
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                        <a href="{{ route('empresas.edit', $empresa) }}" class="text-indigo-600 hover:text-indigo-900">
                            Editar
                        </a>
                        <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST" class="delete-conf inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- script mejorado con jquery para preguntar al usuario si esta seguro de tomar acción en el eliminado de la empresa -->
<script>
    $('.delete-conf').on('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: "¿Esta seguro que desea eliminar la empresa?",
            text: "Esta acción es irreversible!",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Eliminar"
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit()
            }
        });
    });
</script>

{{-- Iterador para cuando se crea la empresa de manera satisfactoria --}}
@if (Session::has('EmpresaCreada'))
        <script>
            Swal.fire({
                title: "Empresa creada con exito",
                icon: "success"
            });
        </script>
@endif

{{-- Iterador para cuando se crea la empresa de manera satisfactoria --}}
@if (Session::has('actualizarEmpresa'))
        <script>
            Swal.fire({
                title: "Empresa actualizada con exito",
                icon: "success"
            });
        </script>
@endif

{{-- Iterador para cuando se elimine una empresa --}}
@if (Session::has('empresaEliminada'))
        <script>
            Swal.fire({
                title: "Empresa eliminada con éxito",
                icon: "success"
            });
        </script>
@endif

@endsection

<!-- script para preguntar al usuario si esta seguro de tomar acción en el eliminado del pago -->
{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Seleccionar todos los formularios con la clase 'delete-conf'
        var forms = document.querySelectorAll('.delete-conf');
        
        forms.forEach(function(form) {
            form.addEventListener('submit', function (event) {
                var confirmation = confirm('¿Estás seguro de que quieres eliminar esta empresa?');
                if (!confirmation) {
                    event.preventDefault();
                }
            });
        });
    });
</script> --}}
