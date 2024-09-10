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
            // Buscar la empresa por ID proporcionado en la solicitud
            $empresa = Empresa::find($request->empresa_id);
        
            if (!$empresa) {
                // Manejar el caso en que no se encuentra la empresa
                return redirect()->route('home.estudiante')->with('error', 'Empresa no encontrada');
            }
        
            // Obtener todos los empleados asociados a la empresa
            $empleados = Empleado::where('id_empresa', $empresa->id)->get();
        
            // Retornar la vista con la lista de empleados y la empresa
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

    public function show($id)
    {
        $empleado = Empleado::findOrFail($id);

        // Devuelve los datos del empleado en formato JSON
        return response()->json($empleado);
    }
}
