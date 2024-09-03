<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;

class IndexEstudianteController extends Controller
{
    public function mostrarIndexEstudiante(Request $request)
    {
        $empresa = Empresa::find($request->empresa_id);

        if (!$empresa) {
            // Manejar el caso en que no se encuentra la empresa
            return redirect()->route('inicios.index_estudiante')->with('error', 'Empresa no encontrada');
        }
        return view('index_estudiante.index', compact('empresa'));
    }
}
