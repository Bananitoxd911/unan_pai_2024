<?php

namespace App\Http\Controllers\Empleados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Empresa;

class EmpleadosController extends Controller
{
        // Mostrar todos los empleados
        public function index(Request $request)
        {

            $empresa = Empresa::find($request->empresa_id);

            if (!$empresa) {
                // Manejar el caso en que no se encuentra la empresa
                return redirect()->route('inicios.index_estudiante')->with('error', 'Empresa no encontrada');
            }
        
            $empleados = Empleado::where('id_empresa', $empresa->id)->get();

            $empleados = Empleado::where('id_empresa', session('empresa_id'))->get();


            return view('empleados.index', compact('empleados', 'empresa'));
        }
    
        // Mostrar formulario para agregar un nuevo empleado
        public function create()
        {
            $empresas = Empresa::all();
            return view('empleados.create', compact('empresas'));
        }
    
        // Guardar un nuevo empleado
        public function store(Request $request)
        {
            $request->validate([
                'id_empresa' => 'required|exists:empresas,id',
                'primer_nombre' => 'required|string|max:255',
                'primer_apellido' => 'required|string|max:255',
                'numero_inss' => 'required|string|max:255|unique:empleados,numero_inss',
                'cargo' => 'required|string|max:255',
                'salario_bruto' => 'required|numeric',
            ]);
        
            Empleado::create($request->all());
        
            // Redirigir pasando el id de la empresa
            return redirect()->route('empleados.index', ['empresa_id' => $request->id_empresa])
                             ->with('success', 'Empleado agregado exitosamente.');
        }
        
    
        // Marcar un empleado como inactivo
        public function destroy(Empleado $empleado)
        {
            $empleado->activo = false;
            $empleado->save();
    
            return redirect()->route('empleados.index')->with('success', 'Empleado marcado como inactivo.');
        }
}
