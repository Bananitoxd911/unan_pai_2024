<?php

namespace App\Http\Controllers\Inicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empresa;
use App\Models\Estudiante;

class InicioEstudianteController extends Controller
{
    // Mostrar la vista de inicio del estudiante
    public function mostrarInicio()
    {

        // Obtener el estudiante autenticado
        $estudiante = Auth::guard('estudiante')->user();


        // Verificar si el estudiante tiene alguna empresa registrada
        if ($estudiante->empresas()->count() == 0) 
        {
            // Redirigir a la vista para crear una nueva empresa si no tiene ninguna
            return redirect()->route('empresa.create');
        }
        
        else
        {
            $estudiante = Auth::user();
            $empresas = Empresa::where('id_estudiante', $estudiante->id)->get();
            // Si tiene empresas, mostrar la vista de inicio del estudiante
            return view('inicios.index_estudiante', compact('empresas'));
        }


    }
}
