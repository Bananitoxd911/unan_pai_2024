<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Caja_general;
use App\Models\FondoFijo;
use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CajaGeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Buscar la empresa según el id proporcionado
        $empresa = Empresa::findOrFail($request->id_empresa); // Usamos findOrFail para manejar errores si no se encuentra

        // Verificar si la empresa tiene cuenta en banco
        $banco = Banco::where('id_empresa', $empresa->id)->exists(); // Optimizamos con exists()

        if (!$banco) {
            // Si no tiene cuenta, redirigir a la vista para crear una nueva cuenta bancaria
            return view('banco.create', compact('empresa'));
        }

        // Verificar si la empresa tiene un registro de caja chica (Fondo Fijo)
        $fondoFijoExiste = FondoFijo::where('id_empresa', $empresa->id)->exists(); // Usamos exists() para optimización

        if (!$fondoFijoExiste) {
            // Si no tiene fondo fijo, redirigir a la vista de creación de fondo fijo
            return view('fondo_fijo.create', compact('empresa'));
        }

        // Obtener los registros de caja general
        $registros = Caja_general::where('id_empresa', $empresa->id)->get();

        // Obtener el valor actual de los fondos en caja general
        $fondo_actual = DB::table('caja_general_total')
            ->where('id_empresa', $empresa->id)
            ->value('fondos');

        // Redirigir a la vista de caja general con los datos necesarios
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
        // Lógica de pagos para caja chica
        $fondo_actual = DB::table('caja_general_total')
        ->where('id_empresa', $request->id_empresa)
        ->value('fondos'); // Obtener el fondo actual una sola vez

        if ($request->tipo === 'ingreso') {
            // Si es ingreso, sumar el monto al fondo actual
            $nuevo_fondo = $fondo_actual + $request->monto;
        } else {
            // Verificar si el fondo actual es suficiente para el egreso
            if ($fondo_actual < $request->monto) {
                return redirect()->back()->with('DemasiadoParaEgreso', 'DemasiadoParaEgreso'); // Redirigir si no hay suficientes fondos
            }
            // Si es egreso, restar el monto del fondo actual
            $nuevo_fondo = $fondo_actual - $request->monto;
        }

        // Actualizar el fondo en la base de datos
        DB::table('caja_general_total')->where('id_empresa', $request->id_empresa)->update([
        'fondos'     => $nuevo_fondo,
        'updated_at' => now() // Usar el helper now() para la marca de tiempo
        ]);

        // Generar el registro en la tabla Caja_general
        Caja_general::create([
        'id_empresa'  => $request->id_empresa,
        'descripcion' => $request->OP,
        'tipo'        => $request->tipo,
        'monto'       => $request->monto,
        ]);

        // Redirigir a la vista de caja general con un mensaje de éxito
        return redirect()->route('caja_general.index', ['id_empresa' => $request->id_empresa])
        ->with('RegistroGuardado', 'RegistroGuardado');

    }

    public function abono(Request $request){
        // Verificar si la cuenta existe
        $existe_cuenta = DB::table('banco_balance_total')
        ->where('numero_de_cuenta', $request->cuenta)
        ->where('id_empresa', $request->id_empresa) // Filtrar por empresa directamente
        ->exists();

        if (!$existe_cuenta) {
            return redirect()->back()->with('noExisteCuenta', 'noExisteCuenta'); // La cuenta no existe
        }

        // Obtener los fondos del banco y de la caja general
        $fondo_banco = DB::table('banco_balance_total')
        ->where('id_empresa', $request->id_empresa)
        ->value('balance');

        $fondo_general = DB::table('caja_general_total')
        ->where('id_empresa', $request->id_empresa)
        ->value('fondos');

        // Verificar si hay fondos suficientes en la caja general
        if ($fondo_general < $request->monto) {
            return redirect()->back()->with('fondoInsuficiente', 'fondoInsuficiente'); // Fondos insuficientes
        }

        // Actualizar el balance del banco
        DB::table('banco_balance_total')
        ->where('id_empresa', $request->id_empresa)
        ->update([
            'balance'    => $fondo_banco + $request->monto,
            'updated_at' => now(), // Usar el helper now()
        ]);

        // Actualizar el fondo en la caja general
        DB::table('caja_general_total')
        ->where('id_empresa', $request->id_empresa)
        ->update([
            'fondos'     => $fondo_general - $request->monto,
            'updated_at' => now(),
        ]);

        // Crear registro en banco
        Banco::create([
        'id_empresa' => $request->id_empresa,
        'operacion'  => 'Abono de dinero desde caja general',
        'balance'    => $request->monto,
        ]);

        // Crear registro en caja general
        Caja_general::create([
        'id_empresa'  => $request->id_empresa,
        'descripcion' => 'Abono de dinero para banco',
        'monto'       => $request->monto,
        'tipo'        => 'egreso',
        ]);

        // Redirigir a la vista de caja general con un mensaje de éxito
        return redirect()->route('caja_general.index', ['id_empresa' => $request->id_empresa])
        ->with('abonoHecho', 'abonoHecho');    
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

    // Este metodo último solo esta de prueba y debe de ser eliminado en el producto final, sirve para borrar todo en cuanto a
    // caja chica, caja general, fondo fijo
    public function destroy_all(Request $request){
        Caja_general::where('id_empresa', $request->id)->delete();
        FondoFijo::where('id_empresa', $request->id)->delete();
        Banco::where('id_empresa', $request->id)->delete();
        DB::table('fondo_fijo_totales')->where('id_empresa', $request->id)->delete();
        DB::table('banco_balance_total')->where('id_empresa', $request->id)->delete();
        DB::table('caja_general_total')->where('id_empresa', $request->id)->delete();

        //Generar registro de caja general.
        DB::table('caja_general_total')->insert([
            'id_empresa' => $request->id,
            'fondos'     => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        return redirect()->route('home.estudiante');
    }
}
