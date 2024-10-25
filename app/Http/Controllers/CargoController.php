<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\DepartamentoCargo;

class CargoController extends Controller
{
        /**
     * Almacena un nuevo cargo y lo asigna a un departamento.
     */
    /**
     * Función para almacenar un nuevo cargo y asignarlo a un departamento.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);

        // Crear el cargo
        $cargo = Cargo::create([
            'nombre' => $request->nombre,
        ]);

        // Asociar el cargo con el departamento en la tabla de relaciones
        DepartamentoCargo::create([
            'departamento_id' => $request->departamento_id,
            'cargo_id' => $cargo->id,
        ]);

        // Redireccionar con un mensaje de éxito
        return redirect()->back()->with('success', 'Cargo creado y asignado al departamento correctamente.');
    }
}
