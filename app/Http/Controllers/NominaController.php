<?php

namespace App\Http\Controllers;

use App\Models\Nomina;
use App\Models\Empresa;
use App\Models\Empleado;
use Illuminate\Http\Request;

class NominaController extends Controller
{
    public function index(Request $request)
    {
        // Buscar la empresa por ID proporcionado en la solicitud
        $empresa = Empresa::find($request->empresa_id);
    
        if (!$empresa) {
            // Manejar el caso en que no se encuentra la empresa
            return redirect()->route('home.estudiante')->with('error', 'Empresa no encontrada.');
        }
    
        // Obtener las nóminas de la empresa específica
        $nominas = Nomina::where('id_empresa', $empresa->id)->with('empresa')->paginate(10);
    
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
    
        // Obtener todos los empleados
        $empleados = Empleado::all();
        
        // Pasar solo el ID de la empresa y la empresa completa a la vista
        $empresaId = $empresa->id;
        return view('nominas.create', compact('empleados', 'empresaId', 'empresa'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'id_empresa' => 'required|exists:empresas,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric',
            'detalles.*.id_empleado' => 'required|exists:empleados,id',
            'detalles.*.salario_bruto' => 'required|numeric',
            'detalles.*.cantidad_hrs_extra' => 'required|integer',
            'detalles.*.antiguedad_porcentaje' => 'required|numeric',
            'detalles.*.antiguedad_monto' => 'required|numeric',
            'detalles.*.ir' => 'required|numeric',
            'detalles.*.inss_patronal' => 'required|numeric',
            'detalles.*.vacaciones' => 'required|numeric',
            'detalles.*.treceavo_mes' => 'required|numeric',
        ]);

        $nomina = Nomina::create([
            'id_empresa' => $request->id_empresa,
            'fecha' => $request->fecha,
            'total' => $request->total,
        ]);

        foreach ($request->detalles as $detalle) {
            $nomina->detalleNomina()->create($detalle);
        }

        $empresa_id = Empresa::findOrFail($request->id_empresa);

        return redirect()->route('nominas.index', compact('empresa_id'))->with('success', 'Nómina creada con éxito.');
    }

    public function show($nomina, $empresa)
    {
        // Obtener la nómina por ID con los detalles relacionados
        $nomina = Nomina::findOrFail($nomina);
        $empresa = Empresa::findOrFail($empresa);
        
        return view('nominas.show', compact('nomina', 'empresa'));
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
    
        // Elimina la nómina
        $nomina->delete();
    
        // Redirigir a la lista de nóminas de la empresa
        return redirect()->route('nominas.index', ['empresa_id' => $empresaId])
                        ->with('success', 'Nómina eliminada con éxito.');
    }


}