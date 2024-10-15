<!-- Botón para abrir el modal para cada fila -->
<button type="button" class="bg-blue-500 text-white absolute right-0 mr-1 px-4 py-2 rounded hover:bg-blue-600 transition duration-300" onclick="abrirModal(0)">C</button>

<!-- Modal para el cálculo de IR -->
<div id="modalIR" class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white text-black p-8 rounded-lg shadow-lg max-w-lg w-full">
        <h2 class="text-2xl font-semibold mb-4 text-center">Cálculo del IR</h2>

        <!-- Select para seleccionar el impuesto base -->
        <label for="impuestoBase" class="block text-sm font-medium mb-1">Impuesto base:</label>
        <select id="impuestoBase" class="form-control mb-4 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            <option value="0" selected>C$ 0.00</option>
            <option value="15000">C$ 15,000.00</option>
            <option value="45000">C$ 45,000.00</option>
            <option value="82500">C$ 82,500.00</option>
        </select>

        <!-- Select para seleccionar el porcentaje aplicable -->
        <label for="porcentaje" class="block text-sm font-medium mb-1">Porcentaje aplicable:</label>
        <select id="porcentaje" class="form-control mb-4 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            <option value="0">0%</option>
            <option value="0.15">15%</option>
            <option value="0.20">20%</option>
            <option value="0.25">25%</option>
            <option value="0.30">30%</option>
        </select>

        <!-- Select para seleccionar el sobre exceso -->
        <label for="sobreExceso" class="block text-sm font-medium mb-1">Sobre exceso:</label>
        <select id="sobreExceso" class="form-control mb-4 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            <option value="0">C$ 0</option>
            <option value="100000">C$ 100,000.00</option>
            <option value="200000">C$ 200,000.00</option>
            <option value="350000">C$ 350,000.00</option>
            <option value="500000">C$ 500,000.00</option>
        </select>

        <!-- Botón para calcular el IR dentro del modal -->
        <button id="calcularIRBtn" type="button" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition duration-300 w-full mb-4">Calcular IR</button>

        <!-- Botón para cerrar el modal -->
        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-300 w-full" onclick="cerrarModal(0)">Cerrar</button>
    </div>
</div>
