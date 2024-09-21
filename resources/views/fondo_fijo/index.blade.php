@extends('layouts.nomina')

@section('contenido')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <!-- Botón para abrir el modal -->
    <button onclick="openModal()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Agregar Gasto</button>
    <button onclick="openModalRem()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Pedir Reembolso</button>


    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Caja Chica
            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Registros en la empresa {{ $empresa->nombre }}.</p>
        </caption>
        <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Usted tiene {{ number_format($fondo_actual) }} C$ en su caja chica
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
            @foreach ($gastos as $gasto)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $gasto->created_at->format('d-m-Y') }}</td>
                    <td class="px-6 py-4">{{ $gasto->descripcion }}</td>
                    <td class="px-6 py-4">{{ $gasto->tipo }}</td>
                    <td class="px-6 py-4">{{ number_format($gasto->monto, 2) }} C$</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal y Overlay para agregar un nuevo gasto -->
<div id="modalOverlay" class="fixed inset-0 z-40 hidden bg-gray-900 bg-opacity-50"></div>

<div id="addPagoModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto h-modal h-full">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-end ">
                    Agregar Nuevo Gasto
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
                <form action="{{ route('fondo_fijo.store') }}" method="POST" class="max-w-md mx-auto">
                    @csrf
                    <!-- Campo oculto para el reembolso -->
                    <input type="hidden" name="id_empresa" value="{{ $empresa->id }}">
                   

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="OP" id="floating_OP_desc" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" title="Solo se permiten letras, números y espacios después del primer carácter." placeholder="" pattern="^[a-zA-Z0-9à-úÀ-Ú.,-_:;]+(\s[a-zA-Z0-9à-úÀ-Ú.,-_:;]+)*$" minlength="20" maxlength="60" value="{{ old('OP') }}" required />
                        <label for="floating_OP_desc" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Descripción de la Operación</label>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="number" name="monto" id="floating_monto" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" min="1" max="{{ $fondo_actual }}" value="{{ old('monto') }}" step="0.01" required />
                        <label for="floating_monto" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Monto</label>
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

<!-- Modal y Overlay para el reembolso de banco -->
<div id="modalOverlayRem" class="fixed inset-0 z-40 hidden bg-gray-900 bg-opacity-50"></div>

<div id="addPagoModalRem" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto h-modal h-full">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-end ">
                    Reembolso de fondo fijo
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeModalRem()">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <form action="{{ route('fondo_fijo.reembolso') }}" method="POST" class="max-w-md mx-auto">
                    @csrf
                    <!-- Campo oculto para la empresa -->
                    <input type="hidden" name="id_empresa" value="{{ $empresa->id }}">

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" pattern="\d{6}" name="cuenta" id="floating_cuenta" title="La cuenta consta de 6 dígitos numéricos sin espacios." class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ old('cuenta') }}" step="0.01" required />
                        <label for="floating_cuenta" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Número de Cuenta {{ e('(6 dígitos)') }}</label>
                    </div>

                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pedir Reembolso</button>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button onclick="closeModalRem()" type="button" class="btn btn-secondary">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- script para mostrar el modal del formulario de pagos -->
<script>
    function openModal() {
        if({{$fondo_actual}} <= 0){
            Swal.fire({
                title: "¡Ustede no posee fondos en caja chica!",
                icon: "error"
            });

            return
        }

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
    function openModalRem() {
        document.getElementById('addPagoModalRem').classList.remove('hidden');
        document.getElementById('modalOverlayRem').classList.remove('hidden');
    }

    function closeModalRem() {
        document.getElementById('addPagoModalRem').classList.add('hidden');
        document.getElementById('modalOverlayRem').classList.add('hidden');
    }

    // Cerrar el modal si se hace clic en el overlay
    document.getElementById('modalOverlayRem').addEventListener('click', closeModal);
</script>

{{-- Iterador para cuando no se encuentre una empresa para la operación --}}
@if (Session::has('no_empresa'))
        <script>
            Swal.fire({
                title: "¡Empresa no encontrada!",
                icon: "error"
            });
        </script>
@endif

{{-- Iterador para cuando el monto del egreso sea mayor al saldo en caja chica --}}
@if (Session::has('guardadoApertura'))
        <script>
            Swal.fire({
                title: "¡Monto de apertura agregado con éxito!",
                icon: "success"
            });
        </script>
@endif

{{-- Iterador para cuando el monto del egreso sea mayor al saldo en caja chica --}}
@if (Session::has('pagoAgregado'))
        <script>
            Swal.fire({
                title: "¡Gasto agregado con éxito!",
                icon: "success"
            });
        </script>
@endif

{{-- Iterador para cuando se realiza reembolos satisfactoriamente --}}
@if (Session::has('reembolsoHecho'))
        <script>
            Swal.fire({
                title: "¡Reembolso realizado con éxito!",
                icon: "success"
            });
        </script>
@endif

{{-- Iterador para cuando el monto del egreso sea mayor al saldo en caja chica --}}
@if (Session::has('egresoError'))
        <script>
            Swal.fire({
                title: "¡El monto del egreso no debe de ser mayor el saldo en fondo fijo!",
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

{{-- Iterador para cuando no se haya pasao del 60% --}}
@if (Session::has('noGastoNecesario'))
        <script>
            Swal.fire({
                title: "¡Tiene que gastar al menos el 60% para pedir un reembolso!",
                icon: "error"
            });
        </script>
@endif

{{-- Iterador para cuando no se cuente con suficiente dinero en banco para abastecer la caja chica. --}}
@if (Session::has('MontoBancoInsuficiente'))
        <script>
            Swal.fire({
                title: "¡Dinero insuficiente en banco!",
                icon: "error"
            });
        </script>
@endif

@endsection