<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Estudiante;
use App\Models\EstudianteEmpresa;
use App\Models\Empleado;
use App\Models\EmpresaEmpleado;
use App\Models\EmpresaNomina;

class IndexEstudianteController extends Controller
{
    public function mostrarIndexEstudiante(Request $request)
    {
        
        $empresa = EstudianteEmpresa::where('empresa_id', $request->empresa_id)->first();
        $empresa =$empresa->empresa;

        $empleados = EmpresaEmpleado::where('empresa_id', $empresa->id)
        ->with('empleado')  // Cargar la relación empleado
        ->get()
        
        ->pluck('empleado'); // Obtener solo los empleados

        //dd($empresa->all());

        // Obtener las nóminas de la empresa específica
        $nominas = EmpresaNomina::where('empresa_id', $empresa->id)->get();
        return view('index_estudiante.index', compact('empresa', 'empleados', 'nominas'));	
    }
}
