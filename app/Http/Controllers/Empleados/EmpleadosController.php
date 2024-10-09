<?php

namespace App\Http\Controllers\Empleados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Empresa;
use App\Models\Nomina;

class EmpleadosController extends Controller
{
        // Mostrar todos los empleados
        public function index(Request $request)
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
        
            if (!$empresa) {
                return redirect()->route('inicios.index_estudiante')->with('error', 'Empresa no encontrada');
            }
        
            // Obtener los empleados de la empresa
            $empleados = Empleado::where('id_empresa', $empresa->id)->get();
        
            return view('empleados.index', compact('empleados', 'empresa'));
        }
        
        // Método para actualizar el empleado
        public function update(Request $request, $id)
        {
            // Validar los datos del formulario
            $request->validate([
                'primer_nombre' => 'required|string|max:255',
                'segundo_nombre' => 'nullable|string|max:255',
                'primer_apellido' => 'required|string|max:255',
                'segundo_apellido' => 'nullable|string|max:255',
                'numero_inss' => 'required|string|max:12',
                'cargo' => 'required|string|max:255',
                'salario_bruto' => 'required|numeric',
                'id_empresa' => 'required|exists:empresas,id',
            ]);

            // Buscar la empresa
            $empresa_id =$request->id_empresa;

            // Actualizar el empleado
            $empleado = Empleado::findOrFail($id);
            $empleado->update($request->all());

            // Redirigir con un mensaje de éxito
            return redirect()->route('empleados.index', compact('empresa_id'))->with('success', 'Empleado actualizado correctamente.');
        }



    
        // Marcar un empleado como inactivo
        public function destroy(Empleado $empleado)
        {
            $empleado->activo = false;
            $empleado->save();
    
            return redirect()->route('empleados.index')->with('success', 'Empleado marcado como inactivo.');
        }


    // Método para mostrar la vista del formulario
    public function ingresosEmpleados(Request $request, $empresa_id)
    {
        $empleados = Empleado::all();
        $empresa = Empleado::findOrFail($empresa_id);  // Buscar la empresa por el ID
        
        // Retornar la vista con los empleados y empresa
        return view('empleados.informe_ingreso', compact('empleados', 'empresa'));
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
            
}
