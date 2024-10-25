<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;

class DepartamentoController extends Controller
{
    public function store(Request $request)
    {
        //dd($request->all());
        // Validar la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Crear el departamento
        Departamento::create($request->only('nombre'));

        return redirect()->back()->with('success', 'Cargo creado  departamento correctamente.');
    }
}
