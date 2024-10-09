@extends('layouts.nomina')

@section('contenido')
    <div class="container">
        <h1>Editar Nómina</h1>
        <form action="{{ route('nominas.update', $nomina->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="id_empresa">Empresa</label>
                <select id="id_empresa" name="id_empresa" class="form-control" required>
                    @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}" {{ $nomina->id_empresa == $empresa->id ? 'selected' : '' }}>{{ $empresa->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" class="form-control" value="{{ $nomina->fecha }}" required>
            </div>
            <div class="form-group">
                <label for="total">Total</label>
                <input type="number" id="total" name="total" class="form-control" step="0.01" value="{{ $nomina->total }}" required>
            </div>
            
            <h3>Detalles de Nómina</h3>
            <div id="detalles-container">
                @foreach($nomina->detalleNomina as $index => $detalle)
                    <div class="detalle">
                        <div class="form-group">
                            <label for="detalles[{{ $index }}][id_empleado]">Empleado</label>
                            <select name="detalles[{{ $index }}][id_empleado]" class="form-control" required>
                                @foreach($empleados as $empleado)
                                    <option value="{{ $empleado->id }}" {{ $detalle->id_empleado == $empleado->id ? 'selected' : '' }}>{{ $empleado->nombre_completo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="detalles[{{ $index }}][salario_bruto]">Salario Bruto</label>
                            <input type="number" name="detalles[{{ $index }}][salario_bruto]" class="form-control" step="0.01" value="{{ $detalle->salario_bruto }}" required>
                        </div>
                        <div class="form-group">
                            <label for="detalles[{{ $index }}][cantidad_hrs_extra]">Horas Extra</label>
                            <input type="number" name="detalles[{{ $index }}][cantidad_hrs_extra]" class="form-control" value="{{ $detalle->cantidad_hrs_extra }}" required>
                        </div>
                        <div class="form-group">
                            <label for="detalles[{{ $index }}][inss_patronal]">INSS Patronal</label>
                            <input type="number" name="detalles[{{ $index }}][inss_patronal]" class="form-control" step="0.01" value="{{ $detalle->inss_patronal }}" required>
                        </div>
                        <div class="form-group">
                            <label for="detalles[{{ $index }}][vacaciones]">Vacaciones</label>
                            <input type="number" name="detalles[{{ $index }}][vacaciones]" class="form-control" step="0.01" value="{{ $detalle->vacaciones }}" required>
                        </div>
                        <div class="form-group">
                            <label for="detalles[{{ $index }}][treceavo_mes]">13° Mes</label>
                            <input type="number" name="detalles[{{ $index }}][treceavo_mes]" class="form-control" step="0.01" value="{{ $detalle->treceavo_mes }}" required>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-detail" class="btn btn-secondary">Agregar Detalle</button>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>

    <script>
        document.getElementById('add-detail').addEventListener('click', function () {
            var container = document.getElementById('detalles-container');
            var index = container.querySelectorAll('.detalle').length;
            var newDetail = `
                <div class="detalle">
                    <div class="form-group">
                        <label for="detalles[${index}][id_empleado]">Empleado</label>
                        <select name="detalles[${index}][id_empleado]" class="form-control" required>
                            @foreach($empleados as $empleado)
                                <option value="{{ $empleado->id }}">{{ $empleado->nombre_completo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="detalles[${index}][salario_bruto]">Salario Bruto</label>
                        <input type="number" name="detalles[${index}][salario_bruto]" class="form-control" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="detalles[${index}][cantidad_hrs_extra]">Horas Extra</label>
                        <input type="number" name="detalles[${index}][cantidad_hrs_extra]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="detalles[${index}][inss_patronal]">INSS Patronal</label>
                        <input type="number" name="detalles[${index}][inss_patronal]" class="form-control" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="detalles[${index}][vacaciones]">Vacaciones</label>
                        <input type="number" name="detalles[${index}][vacaciones]" class="form-control" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="detalles[${index}][treceavo_mes]">13° Mes</label>
                        <input type="number" name="detalles[${index}][treceavo_mes]" class="form-control" step="0.01" required>
                    </div>
                </div>`;
            container.insertAdjacentHTML('beforeend', newDetail);
        });
    </script>
@endsection