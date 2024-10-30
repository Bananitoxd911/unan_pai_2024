<div class="mb-4">
    <label for="empresa" class="block text-sm font-medium text-gray-700 dark:text-white">Empresa</label>
    <input type="text" id="empresa" name="empresa" class="form-control dark:bg-slate-800 dark:text-white mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm" value="{{ $empresa->nombre }}" readonly>
    <input type="hidden" name="id_empresa" value="{{ $empresaId }}">
</div>
<div class="mb-4">
    <label for="fecha" class="block text-sm font-medium text-gray-700 dark:text-white">Fecha</label>
    <input type="date" id="fecha" name="fecha" class="form-control dark:bg-slate-800 dark:text-white mt-1 block w-48 bg-gray-100 border border-gray-300 rounded-md shadow-sm" required>
</div>
<div class="mb-4">
    <label for="total" class="block text-sm font-medium text-gray-700 dark:text-white">Total</label>
    <input type="number" id="total" name="total" class="form-control dark:bg-slate-800 dark:text-white mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm" step="0.01" required>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 px-10">
    <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700 bg-slate-500">
        <input id="mensual" type="radio" value="mensual" name="periodo" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        <label for="bordered-radio-1" class="w-full py-4 ms-2 text-sm font-medium text-black dark:text-gray-300">Mensual</label>
    </div>
    <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700 bg-slate-500">
        <input checked id="quincenal" type="radio" value="quincenal" name="periodo" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        <label for="bordered-radio-2" class="w-full py-4 ms-2 text-sm font-medium text-black  dark:text-white">Quincenal</label>
    </div>

</div>

Neto a recibir 
vacaciones 
aguinaldo
patronal
