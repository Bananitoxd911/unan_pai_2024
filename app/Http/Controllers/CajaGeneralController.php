<?php

namespace App\Http\Controllers;

use App\Models\Caja_general;
use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

class CajaGeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::find($request->id_empresa);
        $registros = Caja_general::where('id_empresa', $empresa->id)->get();

        $fondo_actual = DB::table('fondo_fijo_totales')->where('id_empresa', $empresa->id)->value('fondos');
    
        return view('caja_general.index', compact('empresa', 'registros', 'fondo_actual'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Caja_general $caja_general)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Caja_general $caja_general)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Caja_general $caja_general)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Caja_general $caja_general)
    {
        //
    }
}
