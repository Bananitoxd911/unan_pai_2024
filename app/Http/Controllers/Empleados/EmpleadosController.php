<?php

namespace App\Http\Controllers\Empleados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Empresa;
use Illuminate\Validation\Rule;
use App\Models\Nomina;

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
            $empleados = Empleado::where('empresa_id', $empresa->id)->get();
        
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
            //dd($request->all());
            $request->validate([
                'empresa_id' => 'required|exists:empresas,id',
                'primer_nombre' => 'required|string|max:255',
                'primer_apellido' => 'required|string|max:255',
                'numero_inss' => 'required|string|max:255|unique:empleados,numero_inss',
                'cargo' => 'required|string|max:255',
                'antiguedad' => 'required|integer',
                'salario_bruto' => 'required|numeric',
            ]);
        
            // Verificar si el empleado ya pertenece a la empresa
            $existeEmpleado = Empleado::where('numero_inss', $request->numero_inss)
                                    ->where('empresa_id', $request)
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
        
        public function update(Request $request, $id)
        {
            // Buscar al empleado por su id
            $empleado = Empleado::findOrFail($id);

            // Validar los datos recibidos
            $request->validate([
                'empresa_id' => 'required|exists:empresas,id',
                'primer_nombre' => 'required|string|max:255',
                'primer_apellido' => 'required|string|max:255',
                'numero_inss' => [
                    'required', 
                    'string', 
                    'max:255', 
                    Rule::unique('empleados', 'numero_inss')->ignore($empleado->id) // Ignorar el INSS del empleado actual
                ],
                'cargo' => 'required|string|max:255',
                'salario_bruto' => 'required|numeric',
            ]);

            // Verificar si el empleado ya pertenece a la empresa (ignorar el empleado actual)
            $existeEmpleado = Empleado::where('numero_inss', $request->numero_inss)
                                    ->where('empresa_id', $request->id_empresa)
                                    ->where('id', '!=', $empleado->id) // Excluir el empleado actual
                                    ->exists();

            if ($existeEmpleado) {
                return redirect()->back()
                                ->withErrors(['numero_inss' => 'El empleado ya está registrado en esta empresa.'])
                                ->withInput();
            }

            // Actualizar los datos del empleado
            $empleado->update($request->all());

            // Redirigir pasando el id de la empresa
            return redirect()->route('empleados.index', ['empresa_id' => $request->id_empresa])
                            ->with('success', 'Empleado actualizado exitosamente.');
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



     // Método para obtener ingresos y deducciones del empleado en un mes específico
    public function getNominaPorMes($empleadoId, $mes)
    {
        // Buscar las nóminas correspondientes al empleado y al mes
        $nominas = Nomina::whereHas('detalleNomina', function($query) use ($empleadoId) {
            $query->where('id_empleado', $empleadoId);
        })
        ->whereMonth('fecha', $mes)
        ->with(['detalleNomina' => function($query) use ($empleadoId) {
            $query->where('id_empleado', $empleadoId);
        }])
        ->get();
        if ($nominas->isEmpty()) {
            return response()->json(['error' => 'No se encontraron nóminas para el empleado en el mes seleccionado.'], 404);
        }
        // Tomar los detalles de la primera nómina encontrada
        $detalleNomina = $nominas->first()->detalleNomina->first();
        // Preparar los datos para enviar
        $data = [
            'empleado' => $detalleNomina->empleado->primer_nombre . ' ' . $detalleNomina->empleado->primer_apellido,
            'mes' => $mes,
            'salario_bruto' => $detalleNomina->salario_bruto,
            'cantidad_hrs_extra' => $detalleNomina->cantidad_hrs_extra,
            'antiguedad_monto' => $detalleNomina->antiguedad_monto,
            'ir' => $detalleNomina->ir,
            'inss_patronal' => $detalleNomina->inss_patronal,
            'vacaciones' => $detalleNomina->vacaciones,
            'treceavo_mes' => $detalleNomina->treceavo_mes,
            'total_ingresos' => $detalleNomina->salario_bruto + $detalleNomina->cantidad_hrs_extra + $detalleNomina->antiguedad_monto,
            'total_deducciones' => $detalleNomina->ir + $detalleNomina->inss_patronal,
        ];
        return response()->json($data);
    }

    public function checkInss($numero_inss)
    {
        $exists = Empleado::where('numero_inss', $numero_inss)->exists();
        return response()->json(['exists' => $exists]);
    }

}