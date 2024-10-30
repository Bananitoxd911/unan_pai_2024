<button type="button" class="bg-blue-500 text-white absolute right-0 mr-1 px-4 py-2 rounded" onclick="abrirModalVacaciones(0)">C</button>

<div id="modalVacaciones" class="hidden fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white dark:bg-slate-800 p-6 rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Calcular Vacaciones</h2>

        <div class="mb-4">
            <label for="diasVacaciones" class="block mb-2">Días de Vacaciones</label>
            <input type="number" id="diasVacaciones" class="form-control dark:bg-slate-700 dark:text-white w-full bg-gray-100 border border-gray-300 rounded-md" step="0.01" required>
        </div>

        <div class="flex justify-end">
            <button id="calcularVacacionesBtn" class="bg-green-500 text-white px-4 py-2 rounded mr-2">Calcular</button>
            <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="cerrarModalVacaciones()">Cancelar</button>
        </div>
    </div>
</div>
