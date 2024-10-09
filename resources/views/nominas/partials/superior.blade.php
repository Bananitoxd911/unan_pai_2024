<div class="mb-4">
    <label for="empresa" class="block text-sm font-medium text-gray-700">Empresa</label>
    <input type="text" id="empresa" name="empresa" class="form-control mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm" value="{{ $empresa->nombre }}" readonly>
    <input type="hidden" name="id_empresa" value="{{ $empresaId }}">
</div>
<div class="mb-4">
    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
    <input type="date" id="fecha" name="fecha" class="form-control mt-1 block w-48 bg-gray-100 border border-gray-300 rounded-md shadow-sm" required>
</div>
<div class="mb-4">
    <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
    <input type="number" id="total" name="total" class="form-control mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm" step="0.01" required>
</div>