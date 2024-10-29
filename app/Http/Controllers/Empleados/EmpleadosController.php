<?php

namespace App\Http\Controllers\Empleados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Empresa;
use Illuminate\Validation\Rule;
use App\Models\Nomina;
use App\Models\Cargo;
use App\Models\Departamento;
use App\Models\DepartamentoCargo;
use App\Models\EmpresaEmpleado;
use App\Models\EstudianteEmpresa;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\Auth;

class EmpleadosController extends Controller
{
        // Mostrar todos los empleados
        public function index(Request $request, $id)
        {
            //dd($request->empresa_id);
            $departamentos = Departamento::all();
            $cargos = DepartamentoCargo::all();
            $usuario = Auth::user();
            //dd($usuario);

            $empresa = EstudianteEmpresa::where('estudiante_id', $usuario->id)
            ->where('empresa_id', $id)->first()
            ;


            //dd($empresa);

            $empresa = $empresa->empresa;
            //dd($empresa);
            //dd($empresa);


            // Obtener todos los empleados asociados a la empresa
            $empleados = EmpresaEmpleado::where('empresa_id', $empresa->id)
                            ->with('empleado')  // Cargar la relación empleado
                            ->get()
                            ->pluck('empleado'); // Obtener solo los empleados

            //dd($empleados);
            
            // Retornar la vista con la lista de empleados y la empresa
            return view('empleados.index', compact('empleados', 'empresa', 'departamentos', 'cargos'));
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
                'primer_nombre' => 'required|string|max:255',
                'primer_apellido' => 'required|string|max:255',
                'numero_inss' => 'required|string|max:255|unique:empleados,numero_inss',
                'departamentocargo_id' => 'required|integer:exists:departamentocargo,id',
                'antiguedad' => 'required|integer',
                'salario_bruto' => 'required|numeric',
            ]);
        

            // Verificar si el empleado ya pertenece a la empresa
            $existeEmpleado = Empleado::where('numero_inss', $request->numero_inss)
                ->whereHas('empresas', function ($query) use ($request) {
                    $query->where('empresas.id', $request->empresa_id);
                })
                ->exists();

            //dd($existeEmpleado);
            if ($existeEmpleado) 
            {

                return redirect()->back()
                                ->withErrors(['numero_inss' => 'El empleado ya está registrado en esta empresa.'])
                                ->withInput();
            }
        
            // Si no existe, proceder a crear el empleado
            $empleado = Empleado::create($request->all());

            // Asociar el empleado a la empresa
            EmpresaEmpleado::create([
                'empresa_id' => $request->empresa_id,
                'empleado_id' => $empleado->id
                
            ]);
            
            // Redirigir pasando el id de la empresa
            return redirect()->route('empleados.index', ['empresa_id' => $request->empresa_id])
                            ->with('success', 'Empleado agregado exitosamente.');
        }
        

        public function update(Request $request, $id)
        {
            //dd($request->all());
            // Validar los datos recibidos
            $request->validate([
                'primer_nombre' => 'required|string|max:255',
                'segundo_nombre' => 'required|string|max:255',
                'primer_apellido' => 'required|string|max:255',
                'segundo_apellido' => 'required|string|max:255',
                'numero_inss' => 'required|string|max:255',
                'departamentocargo_id' => 'required|exists:departamentocargo,id',
                'antiguedad' => 'required|integer',
                'salario_bruto' => 'required|numeric',
            ]);
        
            // Obtener el empleado por ID
            $empleado = Empleado::findOrFail($request->id_empresa);
        
            // Actualizar los datos del empleado
            $empleado->update([
                'primer_nombre' => $request->primer_nombre,
                'segundo_nombre' => $request->segundo_nombre,
                'primer_apellido' => $request->primer_apellido,
                'segundo_apellido' => $request->segundo_apellido,
                'numero_inss' => $request->numero_inss,
                'departamentocargo_id' => $request->departamentocargo_id,
                'antiguedad' => $request->antiguedad,
                'salario_bruto' => $request->salario_bruto,
            ]);
            //dd($id);
            // Redirigir con mensaje de éxito
            return redirect()->route('empleados.index', ['empresa_id' => $request->id_empleado])
                ->with('success', 'Empleado actualizado exitosamente.');
        }
        
        
        
    
        // Marcar un empleado como inactivo
        public function destroy($empresa_id, $empleado_id)
        {   
            //dd($request->id_empresa);
            $empleado = Empleado::findOrFail($empleado_id);
            //dd($empleado);
            if ($empleado->activo) {
                $empleado->activo = false;
                $empleado->save();
                return redirect()->route('empleados.index', ['empresa_id' => $empresa_id])->with('success', 'Empleado marcado como inactivo.');
            }
            else
            {
                $empleado->activo = true;
                $empleado->save();
                return redirect()->route('empleados.index', ['empresa_id' => $empresa_id])->with('success', 'Empleado marcado como activo.');
            }

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