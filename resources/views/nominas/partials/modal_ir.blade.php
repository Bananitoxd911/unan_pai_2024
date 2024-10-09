<!-- Botón para abrir el modal para cada fila -->
<button type="button" class="bg-blue-500 text-white px-4 py-2 rounded" onclick="abrirModal(0)">Calcular IR</button>

<!-- Modal para el cálculo de IR -->
<div id="modalIR" class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white text-black p-6 rounded-lg">
        <h2 class="text-xl mb-4">Cálculo del IR</h2>

        <!-- Select para seleccionar el impuesto base -->
        <label for="impuestoBase">Impuesto base:</label>
        <select id="impuestoBase" class="form-control mb-4">
            <option value="0" selected>C$ 0.00</option>
            <option value="15000">C$ 15,000.00</option>
            <option value="45000">C$ 45,000.00</option>
            <option value="82500">C$ 82,500.00</option>
        </select>

        <!-- Select para seleccionar el porcentaje aplicable -->
        <label for="porcentaje">Porcentaje aplicable:</label>
        <select id="porcentaje" class="form-control mb-4">
            <option value="0">0%</option>
            <option value="0.15">15%</option>
            <option value="0.20">20%</option>
            <option value="0.25">25%</option>
            <option value="0.30">30%</option>
        </select>

        <!-- Select para seleccionar el sobre exceso -->
        <label for="sobreExceso">Sobre exceso:</label>
        <select id="sobreExceso" class="form-control mb-4">
            <option value="0">C$ 0</option>
            <option value="100000">C$ 100,000.00</option>
            <option value="200000">C$ 200,000.00</option>
            <option value="350000">C$ 350,000.00</option>
            <option value="500000">C$ 500,000.00</option>
        </select>

        <!-- Botón para calcular el IR dentro del modal -->
        <button id="calcularIRBtn" type="button" class="btn btn-primary">Calcular IR</button>

        <!-- Botón para cerrar el modal -->
        <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="cerrarModal()">Cerrar</button>
    </div>
</div>
