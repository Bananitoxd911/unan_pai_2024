<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nomina;
use App\Models\Empresa;
use App\Models\Empleado;

class InformeController extends Controller
{
    public function empleados($empresa_id)
    {

        $empleados = Empleado::all();
        $empresa = Empresa::findOrFail($empresa_id);  // Buscar la empresa por el ID
        return view('empleados.informe_ingreso', compact('empleados', 'empresa'));
    }
}
