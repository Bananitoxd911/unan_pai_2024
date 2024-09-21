<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Utilizo este método para asegurar que, si la empresa no existe, se maneje con un error 404 automáticamente.
        $empresa = Empresa::findOrFail($request->id_empresa);

        // Obtener las cuentas de banco asociadas a la empresa.
        $cuentas = Banco::where('id_empresa', $empresa->id)->get();

        // Si no hay cuentas, redirigir a la vista de creación.
        if ($cuentas->isEmpty()) {
            return view('banco.create', compact('empresa'));
        }

        // Obtener balance y número de cuenta en una sola consulta.
        $banco_balance = DB::table('banco_balance_total')
            ->where('id_empresa', $empresa->id)
            ->first(['balance', 'numero_de_cuenta']);

        // Si no se encuentra balance o número de cuenta, inicializar con null o algún valor por defecto.
        $cuenta_actual = $banco_balance->balance ?? null;
        $numero_cuenta = $banco_balance->numero_de_cuenta ?? null;

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
        // Verificar si se proporcionó la empresa
        if (!$request->has('id_empresa')) {
            return redirect()->back()->with('no_empresa', 'no_empresa');
        }

        // Validar si la cuenta ya existe en la tabla banco_balance_total
        $cuentaExistente = DB::table('banco_balance_total')
            ->where('numero_de_cuenta', $request->nCuenta)
            ->exists(); // Usamos exists() para optimizar la consulta

        if ($cuentaExistente) {
            // Si la cuenta ya existe, redirigir con un mensaje de error
            return redirect()->back()->withInput()->with('cuentaExiste', 'cuentaExiste');
        }

        // Crear el registro en la tabla Banco
        Banco::create([
            'id_empresa' => $request->id_empresa,
            'operacion'  => 'Apertura de cuenta bancaria',
            'balance'    => $request->balance,
        ]);

        // Insertar el nuevo registro en banco_balance_total
        DB::table('banco_balance_total')->insert([
            'id_empresa'       => $request->id_empresa,
            'numero_de_cuenta' => $request->nCuenta,
            'balance'          => $request->balance,
            'balance_max'      => $request->balance,
            'created_at'       => now(), // Simplificado usando el helper now()
            'updated_at'       => now()
        ]);

        // Redirigir al índice de banco con un mensaje de éxito
        return redirect()->route('banco.index', ['id_empresa' => $request->id_empresa])
            ->with('cuentaBancoCreada', 'cuentaBancoCreada');
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
