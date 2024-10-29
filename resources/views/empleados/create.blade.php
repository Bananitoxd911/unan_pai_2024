<!-- resources/views/empleados/create.blade.php -->

@extends('layouts.nomina')

@section('contenido')
<div class="container">
    <h1>Agregar Nuevo Empleado</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('empleados.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="id_empresa">Empresa</label>
            <select name="id_empresa" id="id_empresa" class="form-control">
                @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="primer_nombre">Primer Nombre</label>
            <input type="text" name="primer_nombre" class="form-control" value="{{ old('primer_nombre') }}">
        </div>

        <div class="form-group">
            <label for="segundo_nombre">Segundo Nombre</label>
            <input type="text" name="segundo_nombre" class="form-control" value="{{ old('segundo_nombre') }}">
        </div>

        <div class="form-group">
            <label for="primer_apellido">Primer Apellido</label>
            <input type="text" name="primer_apellido" class="form-control" value="{{ old('primer_apellido') }}">
        </div>

        <div class="form-group">
            <label for="segundo_apellido">Segundo Apellido</label>
            <input type="text" name="segundo_apellido" class="form-control" value="{{ old('segundo_apellido') }}">
        </div>

        <div class="form-group">
            <label for="numero_inss">Número INSS</label>
            <input type="text" name="numero_inss" class="form-control" value="{{ old('numero_inss') }}">
        </div>

        <div class="form-group">
            <label for="cargo">Cargo</label>
            <select name="cargo" id="">
                @foreach($cargos as $cargo)
                    <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                @endforeach
            </select>

        </div>

        <div class="form-group">
            <label for="salario_bruto">Salario Bruto</label>
            <input type="number" name="salario_bruto" class="form-control" step="0.01" value="{{ old('salario_bruto') }}">
        </div>

        <button type="submit" class="btn btn-success">Agregar Empleado</button>
    </form>
</div>
@endsection
