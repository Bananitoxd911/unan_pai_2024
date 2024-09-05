<?php

namespace App\Http\Controllers;

use App\Models\FondoFijo;
use Illuminate\Http\Request;
use App\Models\Empresa;

class FondoFijoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::find($request->empresa_id);
        $pagos = FondoFijo::where('id_empresa', $empresa->id)->get();

        return view('fondo_fijo.index', compact('empresa', 'pagos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (!$request->id_empresa) {
            return redirect()->back()->with('error', 'Empresa no encontrada');
        }

        FondoFijo::create([
            'id_empresa' => $request->id_empresa,
            'descripcion_de_operacion' => $request->input('OP'),
            'monto' => $request->input('monto'),
        ]);

        return redirect()->route('fondo_fijo.index', ['empresa_id' => $request->id_empresa])->with('success', 'Pago agregado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FondoFijo $fondoFijo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FondoFijo $fondoFijo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FondoFijo $fondoFijo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $pago = FondoFijo::findOrFail($id);
        $pago->delete();

        return redirect()->route('fondo_fijo.index', ['empresa_id' => $request->id_empresa])->with('success', 'Pago agregado exitosamente.');
    }
}
