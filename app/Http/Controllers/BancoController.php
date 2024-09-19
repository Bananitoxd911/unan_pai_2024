<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::find($request->id_empresa);
        $cuentas = Banco::where('id_empresa', $empresa->id)->get();
        $cuenta_actual = DB::table('banco_balance_total')->where('id_empresa', $empresa->id)->value('balance');
        $numero_cuenta = DB::table('banco_balance_total')->where('id_empresa', $empresa->id)->value('numero_de_cuenta');

        if($cuentas->isEmpty()){
            return view('banco.create', compact('empresa'));
        }

        return view('banco.index', compact('empresa', 'cuentas', 'cuenta_actual', 'numero_cuenta'));
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

        //Validar si la cuenta ya existe
        $existe = DB::table('banco_balance_total')->where('numero_de_cuenta','=', $request->input('nCuenta'))->get();

        if($existe->isNotEmpty()){
            return redirect()->back()->withInput()->with('cuentaExiste','cuentaExiste');
        }

        Banco::create([
            'id_empresa' => $request->id_empresa,
            'operacion'  => 'Apertura de cuenta bancaria',
            'balance'    => $request->input('balance'),
        ]);

        DB::table('banco_balance_total')->insert([
            'id_empresa'       => $request->id_empresa,
            'numero_de_cuenta' => $request->input('nCuenta'),
            'balance'          => $request->input('balance'),
            'balance_max'      => $request->input('balance'),
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        return redirect()->route('banco.index', ['id_empresa' => $request->id_empresa])->with('cuentaBancoCreada', 'cuentaBancoCreada');
    }

    //Función para llevar a cabo la apertura del banco.
    public function inicioBanco(){

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
