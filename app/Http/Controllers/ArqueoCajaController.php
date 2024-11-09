<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class ArqueoCajaController extends Controller
{
    public function index(Request $request){

        // Buscar la empresa por ID proporcionado en la solicitud
        $empresa = Empresa::find($request->empresa_id);

        if (!$empresa) {
            // Manejar el caso en que no se encuentra la empresa
            return redirect()->route('home.estudiante')->with('error', 'Empresa no encontrada.');
        }
        return view('arqueoCaja.index', compact('empresa'));

    }
}
