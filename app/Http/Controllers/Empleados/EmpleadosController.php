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
        
            // Verificar si el empleado ya pertenece a la empresa
            $existeEmpleado = Empleado::where('numero_inss', $request->numero_inss)
                                    ->where('id_empresa', $request->id_empresa)
                                    ->exists();
        
            if ($existeEmpleado) {
                return redirect()->back()
                                ->withErrors(['numero_inss' => 'El empleado ya está registrado en esta empresa.'])
                                ->withInput();
            }
        
            // Si no existe, proceder a crear el empleado
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


    public function indemnizaciones(Request $request)
    {
        // Obtener empresa_id del request
        $empresa_id = $request->empresa_id;
        
        // Si no existe, podrías obtenerlo de la sesión (si aplicas esta lógica)
        if (!$empresa_id) {
            $empresa_id = session('empresa_id');
        }
    
        // Si no hay empresa_id, redirigir con un error
        if (!$empresa_id) {
            return redirect()->route('inicios.index_estudiante')->with('error', 'Empresa no encontrada');
        }
    
        // Buscar la empresa
        $empresa = Empresa::find($empresa_id);
        return view('empleados.indemnizacion', compact('empresa'));
    }
}