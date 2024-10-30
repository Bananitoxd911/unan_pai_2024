@extends('layouts.principal')

@section('contenido')





        @if (isset($empresas))
        <div class="w-screen grid place-items-center justify-items-center mx-auto py-6 sm:px-6 lg:px-8">
            <a href="{{ route('empresas.create') }}" clase="w-full">
                <button type="button" class="text-white bg-blue-700 w-full hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-4 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Agregar Nueva Empresa
                </button>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 justify-items-center">
            @foreach($empresas as $empresa)
                <div class="w-full max-w-xs bg-white border p-10 border-gray-200 rounded-lg shadow dark:bg-slate-800 dark:border-gray-700">
                    <a href="#">
                        <img class="rounded-t-lg w-full h-40 object-contain" src="{{ asset('storage/' . $empresa->empresa->logo) }}" alt="{{ $empresa->empresa->nombre }}" />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-2 text-xl text-center font-bold tracking-tight text-gray-900 dark:text-white">{{ $empresa->empresa->nombre }}</h5>
                        </a>
                        <div class="grid grid-cols-1 gap-2 mt-4 sm:grid-cols-2 w-full justify-items-center">
                            <div class="grid place-items-center justify-items-center w-full">
                                <a href="{{route('index.estudiante', ['empresa_id' => $empresa->empresa->id])}}" class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                                    Acceder
                                </a>
                            </div>
                            <div class="grid place-items-center justify-items-center w-full">
                                <a href="{{ route('empresas.edit', $empresa->empresa) }}" class="middle none center rounded-lg bg-orange-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-orange-500/20 transition-all hover:shadow-lg hover:shadow-orange-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                                    Editar
                                </a>
                            </div>

                            <!-- Ajuste para que el botón Eliminar ocupe dos columnas -->
                            <div class="col-span-2 grid justify-items-center w-full">
                                <form action="{{ route('empresas.destroy', $empresa->empresa->id) }}" method="POST" class="delete-conf w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 w-full">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        @else

        <div class="h-screen w-screen flex items-center justify-center">
            <a href="{{ route('empresas.create') }}" class="w-full h-full">
                <button type="button" class="w-full h-full grid place-items-center grid-rows-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-lg py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <div>
                        @include('svg.edificio')
                    </div>
                    <div>
                        Agregar Nueva Empresa <br> (presione el edificio)
                    </div>
                    
                </button>
            </a>
        </div>

        @endif



    <script>
    $(document).ready(function () {
        // Función para verificar si el sistema está en modo oscuro
        function isDarkMode() {
            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        }

        // Configuración de colores para modo oscuro y claro
        const confirmButtonColor = isDarkMode() ? "#bb3d3d" : "#d33";
        const cancelButtonColor = isDarkMode() ? "#4a90e2" : "#3085d6";
        const backgroundColor = isDarkMode() ? "#1e293b" : "#ffffff"; // Fondo oscuro para el modal
        const titleColor = isDarkMode() ? "#ffffff" : "#333333"; // Color del título según el modo

        // Confirmación de eliminación con modo oscuro
        $('.delete-conf').on('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: "¿Está seguro que desea eliminar la empresa?",
                text: "¡Esta acción es irreversible!",
                icon: "warning",
                background: backgroundColor,
                color: titleColor,
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: confirmButtonColor,
                cancelButtonColor: cancelButtonColor,
                confirmButtonText: "Eliminar"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Notificación de éxito para creación de empresa
        @if (Session::has('EmpresaCreada'))
            Swal.fire({
                title: "Empresa creada con éxito",
                icon: "success",
                background: backgroundColor,
                color: titleColor
            });
        @endif

        // Notificación de éxito para actualización de empresa
        @if (Session::has('actualizarEmpresa'))
            Swal.fire({
                title: "Empresa actualizada con éxito",
                icon: "success",
                background: backgroundColor,
                color: titleColor
            });
        @endif

        // Notificación de éxito para eliminación de empresa
        @if (Session::has('empresaEliminada'))
            Swal.fire({
                title: "Empresa eliminada con éxito",
                icon: "success",
                background: backgroundColor,
                color: titleColor
            });
        @endif
    });
</script>


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
