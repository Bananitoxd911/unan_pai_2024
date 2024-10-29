<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Estudiante;
use App\Models\EstudianteEmpresa;

class IndexEstudianteController extends Controller
{
    public function mostrarIndexEstudiante(Request $request)
    {
        
        $empresa = EstudianteEmpresa::where('empresa_id', $request->empresa_id)->first();
        $empresa =$empresa->empresa;
        //dd($empresa->all());


        return view('index_estudiante.index', compact('empresa'));
    }
}
