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
                    <img class="rounded-t-lg w-full h-40 object-cover" src="{{ asset('storage/' . $empresa->logo) }}" alt="{{ $empresa->nombre }}" />
                </a>
                <div class="p-5">
                    <a href="#">
                        <h5 class="mb-2 text-xl text-center font-bold tracking-tight text-gray-900 dark:text-white">{{ $empresa->nombre }}</h5>
                    </a>
                    <div class="grid grid-rows-3 grid-cols-1 gap-2 mt-4 md:grid-cols-2 md:grid-rows-2 w-full place-items-center">
                        <div>
                            <a href="{{route('empleados.index', ['empresa_id' => $empresa->id])}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                Elegir
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('empresas.edit', $empresa) }}" class="middle none center rounded-lg bg-orange-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-orange-500/20 transition-all hover:shadow-lg hover:shadow-orange-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                                Editar
                            </a>
                        </div>

                        <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST" class="delete-con   w-full md:col-span-2 md:grid-cols-subgrid">
                            @csrf
                            @method('DELETE')
                            <div class="flex justify-center items-center">
                                <button type="submit" class="md:w-full  focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Eliminar</button>
                            </div>
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
