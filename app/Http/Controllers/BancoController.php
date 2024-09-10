<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;
use App\Models\Empresa;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::find($request->empresa_id);
        $cuentas = Banco::where('id_empresa', $empresa->id)->get();

        if($cuentas->isEmpty()){
            return view('banco.create', compact('empresa'));
        }

        return view('banco.index', compact('empresa', 'cuentas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('banco.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->id_empresa) {
            return redirect()->back()->with('no_empresa', 'no_empresa');
        }

        $existe = Banco::where('numero_de_cuenta','=', $request->input('nCuenta'))->get();

        if($existe->isNotEmpty()){
            return redirect()->back()->withInput()->with('cuentaExiste','cuentaExiste');
        }

        Banco::create([
            'id_empresa' => $request->id_empresa,
            'numero_de_cuenta' => $request->input('nCuenta'),
            'balance' => $request->input('balance'),
        ]);

        return redirect()->route('banco.index', ['empresa_id' => $request->id_empresa])->with('cuentaBancoCreada', 'cuentaBancoCreada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banco $banco)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banco $banco)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banco $banco)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banco $banco)
    {
        //
    }
}
