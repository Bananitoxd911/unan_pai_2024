<?php

namespace App\Http\Controllers\Inicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empresa;
use App\Models\Estudiante;
use App\Models\EstudianteEmpresa;

class InicioEstudianteController extends Controller
{
    // Mostrar la vista de inicio del estudiante
    public function mostrarInicio()
    {
        $estudiante = Auth::user();

        $empresas = EstudianteEmpresa::where('estudiante_id', $estudiante->id)->get();

        // Si tiene empresas, mostrar la vista de inicio del estudiante
        return view('inicios.index_estudiante', compact('empresas'));
        

    }
}
