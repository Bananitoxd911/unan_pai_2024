<?php

namespace App\Http\Controllers;

use App\Models\DetalleNomina;
use App\Models\Nomina;
use App\Models\Empresa;
use App\Models\Empleado;
use App\Models\EmpresaEmpleado;
use App\Models\EmpresaNomina;
use App\Models\NominaDetalle;
use Illuminate\Http\Request;

class NominaController extends Controller
{
    public function index(Request $request)
    {
        //dd($request->empresa_id);
        // Buscar la empresa por ID proporcionado en la solicitud
        $empresa = Empresa::find($request->empresa_id);
    
        if (!$empresa) {
            // Manejar el caso en que no se encuentra la empresa
            return redirect()->route('home.estudiante')->with('error', 'Empresa no encontrada.');
        }
    
        // Obtener las nóminas de la empresa específica
        $nominas = EmpresaNomina::where('empresa_id', $empresa->id)->get();
        //dd($nominas);
    
        return view('nominas.index', compact('nominas', 'empresa'));
    }
    


    public function create(Request $request)
    {
        // Buscar la empresa por ID proporcionado en la solicitud
        $empresa = Empresa::find($request->empresa_id);
    
        if (!$empresa) {
            // Manejar el caso en que no se encuentra la empresa
            return redirect()->route('home.estudiante')->with('error', 'Empresa no encontrada.');
        }
    
        // Obtener los empleados que pertenecen a la empresa
        $empleados = EmpresaEmpleado::where('empresa_id', $empresa->id)->get();
        //dd($empleados);
        $empleados = $empleados->pluck('empleado');
        // Pasar solo el ID de la empresa y la empresa completa a la vista
        $empresaId = $empresa->id;
        return view('nominas.create', compact('empleados', 'empresaId', 'empresa'));
    }
    
    
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'fecha' => 'required|date',
            'total' => 'required|numeric',
            'detalles.*.empresaempleado_id' => 'required|exists:empresa_empleado,id',
            'detalles.*.salario_bruto' => 'required|numeric',
            'detalles.*.cantidad_hrs_extra' => 'required|integer',
            'detalles.*.antiguedad_porcentaje' => 'required|numeric',

            'detalles.*.total_ingresos' => 'required|numeric',
            'detalles.*.inss_laboral' => 'required|numeric',
            'detalles.*.ir' => 'required|numeric',
            'detalles.*.neto_recibir' => 'required|numeric',
            'detalles.*.inss_patronal' => 'required|numeric',
            'inatec.*.ir' => 'required|numeric',
            'detalles.*.vacaciones' => 'required|numeric',
            'detalles.*.treceavo_mes' => 'required|numeric',
        ]);



        $nomina = Nomina::create([
            'fecha' => $request->fecha,
            'descripcion' => $request->descripcion,
            'periodo' => $request->periodo,
            'total' => $request->total,
        ]);

        EmpresaNomina::create([
            'empresa_id' => $request->id_empresa,
            'nomina_id' => $nomina->id
        ]);
        //dd($nomina);

    // Crear cada detalle de la nómina con id_nomina manualmente
    foreach ($request->detalles as $detalle) {
        $detalle = DetalleNomina::create([
            'empresaempleado_id' => $detalle['empresaempleado_id'],
            'salario_bruto' => $detalle['salario_bruto'],
            'cantidad_hrs_extras' => $detalle['cantidad_hrs_extra'],
            'monto_hrs_extra' => $detalle['hrs_extra_c'] ?? 0, // Valor por defecto si no se proporciona
            'antiguedad_porcentaje' => $detalle['antiguedad_porcentaje'],
            'total_ingreso' => $detalle['total_ingresos'],
            'inss_laboral' => $detalle['inss_laboral'],
            'ir' => $detalle['ir'],
            'total_deducciones' => $detalle['total_deducciones'] ?? 0, // Valor por defecto si no se proporciona
            'neto_recibir' => $detalle['neto_recibir'],
            'inss_patronal' => $detalle['inss_patronal'],
            'inatec' => $detalle['inatec'],
            'vacaciones' => $detalle['vacaciones'],
            'treceavomes' => $detalle['treceavo_mes'],
        ]);

        NominaDetalle::create([
            'nomina_id' => $nomina->id,
            'detalle_id' => $detalle->id,
        ]);
    }


        $empresa_id = Empresa::findOrFail($request->id_empresa);

        return redirect()->route('nominas.index', compact('empresa_id'))->with('success', 'Nómina creada con éxito.');
    }

    public function show($nominaId, $empresaId)
    {
        $empresa = Empresa::findOrFail($empresaId);
        
        // Obtener la nómina con sus detalles relacionados
        $nomina = EmpresaNomina::where('nomina_id', $nominaId)
                    ->with('nomina') // Carga la relación 'nomina'
                    ->firstOrFail();
        
        // Obtener los detalles de la nómina con las relaciones necesarias
        $detalles = NominaDetalle::where('nomina_id', $nominaId)
                    ->with(['detalle', 'detalle.empresaempleado', 'detalle.empresaempleado.empleado', 'detalle.empresaempleado.empleado.departamentocargo', 'detalle.empresaempleado.empleado.departamentocargo.cargo']) // Carga las relaciones
                    ->get();
    
        return view('nominas.show', compact('nomina', 'empresa', 'detalles'));
    }
    
    
    
    
    
    
    
    public function edit(Nomina $nomina)
    {
        $empresas = Empresa::all();
        $empleados = Empleado::all();
        $nomina->load('detalleNomina');
        return view('nominas.edit', compact('nomina', 'empresas', 'empleados'));
    }

    public function update(Request $request, Nomina $nomina)
    {
        $request->validate([
            'id_empresa' => 'required|exists:empresas,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric',
            'detalles.*.id_empleado' => 'required|exists:empleados,id',
            'detalles.*.salario_bruto' => 'required|numeric',
            'detalles.*.cantidad_hrs_extra' => 'required|integer',
            'detalles.*.ir' => 'required|numeric',
            'detalles.*.antiguedad_monto' => 'required|numeric',
            'detalles.*.inss_patronal' => 'required|numeric',
            'detalles.*.vacaciones' => 'required|numeric',
            'detalles.*.treceavo_mes' => 'required|numeric',
        ]);

        $nomina->update([
            'id_empresa' => $request->id_empresa,
            'fecha' => $request->fecha,
            'total' => $request->total,
        ]);

        $nomina->detalleNomina()->delete();
        foreach ($request->detalles as $detalle) {
            $nomina->detalleNomina()->create($detalle);
        }

        return redirect()->route('nominas.index')->with('success', 'Nómina actualizada con éxito.');
    }

    public function destroy(Nomina $nomina)
    {
        // Guardar el id_empresa antes de eliminar la nómina
        $empresaId = $nomina->id_empresa;
        dd($empresaId);
        
        // Elimina la nómina
        $nomina->delete();
    
        // Redirigir a la lista de nóminas de la empresa
        return back()->with('success', 'Nómina eliminada con éxito.');
    }


}