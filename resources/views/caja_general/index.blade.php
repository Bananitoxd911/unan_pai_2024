@extends('layouts.nomina')

@section('contenido')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <!-- Botón para abrir el modal -->
    <button onclick="openModal()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Agregar Pago</button>
    <button onclick="openModalAbon()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Abonar a Banco</button>


    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Caja General
            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Lista de pagos registrados en la empresa {{ $empresa->nombre }}.</p>
        </caption>
        <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Usted tiene {{ number_format($fondo_actual) }} C$ en su caja general
        </caption>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Fecha</th>
                <th scope="col" class="px-6 py-3">Descripción de Operación</th>
                <th scope="col" class="px-6 py-3">Tipo</th>
                <th scope="col" class="px-6 py-3">Monto en C$</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registros as $registro)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $registro->created_at->format('d-m-Y') }}</td>
                    <td class="px-6 py-4">{{ $registro->descripcion }}</td>
                    <td class="px-6 py-4">{{ $registro->tipo }}</td>
                    <td class="px-6 py-4">{{ number_format($registro->monto, 2) }} C$</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal y Overlay de Pagos -->
<div id="modalOverlay" class="fixed inset-0 z-40 hidden bg-gray-900 bg-opacity-50"></div>

<div id="addPagoModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto h-modal h-full">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-end ">
                    Agregar Nuevo Pago
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeModal()">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <form action="{{ route('caja_general.store') }}" method="POST" class="max-w-md mx-auto">
                    @csrf
                    <!-- Campo oculto para el reembolso -->
                    <input type="hidden" name="id_empresa" value="{{ $empresa->id }}">

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="OP" id="floating_OP_desc" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" title="Solo se permiten letras, números y espacios después del primer carácter." placeholder="" pattern="^[a-zA-Z0-9à-úÀ-Ú.,-_:;]+(\s[a-zA-Z0-9à-úÀ-Ú.,-_:;]+)*$" minlength="20" maxlength="60" value="{{ old('OP') }}" required />
                        <label for="floating_OP_desc" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Descripción de la Operación</label>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="number" name="monto" id="floating_monto" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" min="1" max="1000000" value="{{ old('monto') }}" step="0.01" required />
                        <label for="floating_monto" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Monto</label>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
                        <select name="tipo" id="tipo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="ingreso">Ingreso</option>
                            <option value="egreso">Egreso</option>
                        </select>
                    </div>

                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar</button>
                </form>

            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button onclick="closeModal()" type="button" class="btn btn-secondary">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal y Overlay para el abono de banco -->
<div id="modalOverlayAbon" class="fixed inset-0 z-40 hidden bg-gray-900 bg-opacity-50"></div>

<div id="addPagoModalAbon" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto h-modal h-full">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-end ">
                    Abono a Banco
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeModalAbon()">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <form action="{{ route('caja_general.abono') }}" method="POST" class="max-w-md mx-auto">
                    @csrf
                    <!-- Campo oculto para la empresa -->
                    <input type="hidden" name="id_empresa" value="{{ $empresa->id }}">

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" pattern="\d{6}" name="cuenta" id="floating_cuenta" title="La cuenta consta de 6 dígitos numéricos sin espacios." class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ old('cuenta') }}" step="0.01" required />
                        <label for="floating_cuenta" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Número de Cuenta {{ e('(6 dígitos)') }}</label>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="number" name="monto" id="floating_monto" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" min="1" max="{{ $fondo_actual }}" value="{{ old('monto') }}" step="0.01" required />
                        <label for="floating_monto" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Monto</label>
                    </div>

                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Hacer abono</button>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button onclick="closeModalAbon()" type="button" class="btn btn-secondary">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- script para mostrar el modal del formulario de pagos -->
<script>
    function openModal() {
        document.getElementById('addPagoModal').classList.remove('hidden');
        document.getElementById('modalOverlay').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('addPagoModal').classList.add('hidden');
        document.getElementById('modalOverlay').classList.add('hidden');
    }

    // Cerrar el modal si se hace clic en el overlay
    document.getElementById('modalOverlay').addEventListener('click', closeModal);
</script>

<!-- script para mostrar el modal del formulario de reembolso -->
<script>
    function openModalAbon() {
        if({{$fondo_actual}} <= 0){
            Swal.fire({
                title: "¡Ustede no posee fondos en caja general!",
                icon: "error"
            });

            return
        }

        document.getElementById('addPagoModalAbon').classList.remove('hidden');
        document.getElementById('modalOverlayAbon').classList.remove('hidden');
    }

    function closeModalAbon() {
        document.getElementById('addPagoModalAbon').classList.add('hidden');
        document.getElementById('modalOverlayAbon').classList.add('hidden');
    }

    // Cerrar el modal si se hace clic en el overlay
    document.getElementById('modalOverlayAbon').addEventListener('click', closeModal);
</script>

{{-- Iterador para cuando se guarde un registro con éxito --}}
@if (Session::has('RegistroGuardado'))
        <script>
            Swal.fire({
                title: "¡Pago hecho con éxito!",
                icon: "success"
            });
        </script>
@endif

{{-- Iterador para cuando no se pueda cubrir un egreso --}}
@if (Session::has('DemaciadoParaEgreso'))
        <script>
            Swal.fire({
                title: "¡No cuenta con suficiente dinero!",
                icon: "error"
            });
        </script>
@endif

{{-- Iterador para cuando no se disponga de suficiente para el abono --}}
@if (Session::has('fondoInsuficiente'))
        <script>
            Swal.fire({
                title: "¡No cuenta con suficiente dinero!",
                icon: "error"
            });
        </script>
@endif

{{-- Iterador para cuando no exista un numero de cuenta dado --}}
@if (Session::has('noExisteCuenta'))
        <script>
            Swal.fire({
                title: "¡El número de cuenta no existe!",
                icon: "error"
            });
        </script>
@endif

{{-- Iterador para cuando se abone al banco correctamente --}}
@if (Session::has('abonoHecho'))
        <script>
            Swal.fire({
                title: "¡Abono hecho con éxito!",
                icon: "success"
            });
        </script>
@endif

@endsection
