<?php

namespace App\Http\Controllers;

use App\Models\FondoFijo;
use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Banco;
use App\Models\Caja_general;

class FondoFijoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Buscar la empresa por su ID
        $empresa = Empresa::findOrFail($request->id_empresa); // Usar findOrFail para manejo de errores

        // Obtener los gastos de fondo fijo
        $gastos = FondoFijo::where('id_empresa', $empresa->id)->get();

        // Verificar si la empresa tiene cuenta bancaria
        $bancoExiste = Banco::where('id_empresa', $empresa->id)->exists(); // Usar exists() en lugar de get() para optimización

        if (!$bancoExiste) {
            // Redirigir a la vista de creación de cuenta bancaria si no existe
            return view('banco.create', compact('empresa'));
        }

        // Si no hay registros de gastos, redirigir a la vista de creación de fondo fijo
        if ($gastos->isEmpty()) {
            return view('fondo_fijo.create', compact('empresa'));
        }

        // Obtener el fondo actual de la empresa en la tabla 'fondo_fijo_totales'
        $fondo_actual = DB::table('fondo_fijo_totales')
            ->where('id_empresa', $empresa->id)
            ->value('fondos');

        // Mostrar la vista de fondo fijo con los datos de la empresa, gastos y fondo actual
        return view('fondo_fijo.index', compact('empresa', 'gastos', 'fondo_actual'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fondo_fijo.create');
    }


    public function montoApertura(Request $request){
        // Obtener el balance actual del banco para la empresa
        $fondo_banco = DB::table('banco_balance_total')
            ->where('id_empresa', $request->id_empresa)
            ->value('balance');

        // Verificar si el banco tiene suficiente saldo para transferir a fondo fijo
        if ($request->monto > $fondo_banco) {
            return redirect()->back()->with('MontoBancoInsuficiente', 'MontoBancoInsuficiente');
        }

        // Insertar registro en la tabla de fondo fijo total
        DB::table('fondo_fijo_totales')->insert([
            'id_empresa' => $request->id_empresa,
            'fondos'     => $request->monto,
            'fondo_max'  => $request->monto,
            'created_at' => now(), // Usar now() para simplificar
            'updated_at' => now()
        ]);

        // Crear registro de ingreso en la tabla de FondoFijo
        FondoFijo::create([
            'id_empresa'  => $request->id_empresa,
            'descripcion' => 'Apertura de fondo fijo / caja chica',
            'tipo'        => 'ingreso',
            'monto'       => $request->monto,
        ]);

        // Crear registro de ingreso en la tabla Caja_general
        Caja_general::create([
            'id_empresa'  => $request->id_empresa,
            'descripcion' => 'Apertura de fondo fijo / caja chica',
            'tipo'        => 'ingreso',
            'monto'       => $request->monto,
        ]);

        // Actualizar el balance del banco reduciendo el monto transferido
        DB::table('banco_balance_total')->where('id_empresa', $request->id_empresa)->update([
            'balance'    => $fondo_banco - $request->monto,
            'updated_at' => now()
        ]);

        // Crear registro en la tabla de Banco para documentar la transacción
        Banco::create([
            'id_empresa' => $request->id_empresa,
            'operacion'  => 'Retiro de dinero para monto de apertura de caja chica',
            'balance'    => $request->monto,
        ]);

        // Redirigir a la vista de fondo fijo con mensaje de éxito
        return redirect()->route('fondo_fijo.index', ['id_empresa' => $request->id_empresa])
            ->with('guardadoApertura', 'guardadoApertura');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar si se ha proporcionado un ID de empresa
        if (!$request->id_empresa) {
            return redirect()->back()->with('no_empresa', 'no_empresa');
        }

        // Obtener el fondo actual del fondo fijo para la empresa
        $fondo_actual = DB::table('fondo_fijo_totales')
            ->where('id_empresa', $request->id_empresa)
            ->value('fondos');

        // Comprobar si el monto ingresado excede el fondo disponible
        if ($request->input('monto') > $fondo_actual) {
            return redirect()->back()->with('egresoError', 'egresoError');
        }

        // Actualizar el fondo restante después del egreso
        $fondo_actual -= $request->monto;

        DB::table('fondo_fijo_totales')->where('id_empresa', $request->id_empresa)->update([
            'fondos' => $fondo_actual,
            'updated_at' => now() // Usar now() para simplificar
        ]);

        // Crear registro de egreso en la tabla FondoFijo
        FondoFijo::create([
            'id_empresa'  => $request->id_empresa,
            'descripcion' => $request->OP,
            'tipo'        => 'egreso',
            'monto'       => $request->monto,
        ]);

        // Crear registro de egreso en la tabla Caja_general
        Caja_general::create([
            'id_empresa'  => $request->id_empresa,
            'descripcion' => $request->OP,
            'tipo'        => 'egreso',
            'monto'       => $request->monto,
        ]);

        // Redirigir a la vista de fondo fijo con un mensaje de éxito
        return redirect()->route('fondo_fijo.index', ['id_empresa' => $request->id_empresa])
            ->with('pagoAgregado', 'pagoAgregado');

    }

    public function reembolso(Request $request){
        // Verificar si la cuenta existe
        $existe_cuenta = DB::table('banco_balance_total')
        ->where('numero_de_cuenta', $request->cuenta)
        ->where('id_empresa', $request->id_empresa) // Filtrar por empresa directamente
        ->exists();

        if (!$existe_cuenta) {
            return redirect()->back()->with('noExisteCuenta', 'noExisteCuenta'); // La cuenta no existe
        }

        //Obtener datos de tablas
        $data = DB::table('fondo_fijo_totales')->where('id_empresa', $request->id_empresa)->select('fondo_max', 'fondos')->first();
        $fondo_banco = DB::table('banco_balance_total')->where('id_empresa', $request->id_empresa)->value('balance');

        //Verificar si se cuenta con el suficiente saldo en banco para abastecer caja chica.
        if( ($data->fondo_max - $data->fondos) > $fondo_banco ){
            return redirect()->back()->with('MontoBancoInsuficiente', 'MontoBancoInsuficiente');
        }

        //Verificar si se ha gastado al menos el 60% de lo que hay en fondo fijo.
        $porcentajeGastado = (($data->fondo_max - $data->fondos) / $data->fondo_max) * 100;

        if($porcentajeGastado >= 60){
            //Actualizar mi fondo fijo total.
            DB::table('fondo_fijo_totales')->where('id_empresa', $request->id_empresa)->update([
                'fondos'     => $data->fondo_max,
                'updated_at' => Carbon::now()
            ]);

            //Insertar registro en la tabla de fondo fijo para llevarlo de entrada.
            FondoFijo::create([
                'id_empresa'  => $request->id_empresa,
                'descripcion' => 'Reembolso de fondo fijo / caja chica',
                'tipo'        => 'ingreso',
                'monto'       => $data->fondo_max - $data->fondos,
            ]);

            //Actualizar registro para banco total.
            DB::table('banco_balance_total')->where('id_empresa', $request->id_empresa)->update([
                'balance'    => $fondo_banco - ($data->fondo_max - $data->fondos),
                'updated_at' => Carbon::now()
            ]);

            //Crear registro en banco.
            Banco::create([
                'id_empresa' => $request->id_empresa,
                'operacion'  => 'Retiro de dinero para caja chica',
                'balance'    => $data->fondo_max - $data->fondos,
            ]);

            //Crear registro en caja general
            Caja_general::create([
                'id_empresa'  => $request->id_empresa,
                'descripcion' => 'Reembolso de fondo fijo / caja chica',
                'monto'       => $data->fondo_max - $data->fondos,
                'tipo'        => 'ingreso',
            ]);

            return redirect()->route('fondo_fijo.index', ['id_empresa' => $request->id_empresa])->with('reembolsoHecho','reembolsoHecho');
        }else{
            return redirect()->back()->with('noGastoNecesario', 'noGastoNecesario');
        }
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
}
