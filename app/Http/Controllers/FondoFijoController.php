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
        $empresa = Empresa::find($request->id_empresa);
        $gastos = FondoFijo::where('id_empresa', $empresa->id)->get();
        
        //Para cuando no se tenga cuenta en banco.
        $banco = Banco::where('id_empresa', $empresa->id)->get();
        if($banco->isEmpty()){
            return view('banco.create', compact('empresa'));
        }

        //Si no hay ningún pago, entonces se redirige a crear la apertura de caja chica.
        if($gastos->isEmpty()){
            return view('fondo_fijo.create', compact('empresa'));
        }

        $fondo_actual = DB::table('fondo_fijo_totales')->where('id_empresa', $empresa->id)->value('fondos');

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

        //Crear el la tabla de fondo fijo total.
        DB::table('fondo_fijo_totales')->insert([
            'id_empresa' => $request->id_empresa,
            'fondos'     => $request->input('monto'),
            'fondo_max'  => $request->input('monto'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        //Insertar registro en la tabla de pagos para llevarlo de entrada. 
        FondoFijo::create([
            'id_empresa'  => $request->id_empresa,
            'descripcion' => 'Apertura de fondo fijo / caja chica',
            'tipo'        => 'ingreso',
            'monto'       => $request->input('monto'),
        ]);

        //Generar el registro en caja general.
        Caja_general::create([
            'id_empresa'  => $request->id_empresa,
            'descripcion' => 'Apertura de fondo fijo / caja chica',
            'tipo'        => 'ingreso',
            'monto'       => $request->input('monto'),
        ]);

        return redirect()->route('fondo_fijo.index', ['id_empresa' => $request->id_empresa])->with('guardadoApertura','guardadoApertura');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (!$request->id_empresa) {
            return redirect()->back()->with('no_empresa', 'no_empresa');
        }

        //Lógica de pagos para caja chica.
        $fondo_actual = DB::table('fondo_fijo_totales')->where('id_empresa', $request->id_empresa)->value('fondos');

        //Comprobar si el monto ingresado por el usuario es mayor al fondo fijo.
        if($request->input('monto') > $fondo_actual){
            return redirect()->back()->with('egresoError', 'egresoError');
        }

        $fondo_actual = $fondo_actual - $request->input('monto');

        DB::table('fondo_fijo_totales')->where('id_empresa', $request->id_empresa)->update([
            'fondos'=> $fondo_actual,
            'updated_at' => Carbon::now()
        ]);

        //Generar el registro de caja chica.
        FondoFijo::create([
            'id_empresa'  => $request->id_empresa,
            'descripcion' => $request->input('OP'),
            'tipo'        => 'egreso',
            'monto'       => $request->input('monto'),
        ]);

        //Generar el registro en caja general.
        Caja_general::create([
            'id_empresa'  => $request->id_empresa,
            'descripcion' => $request->input('OP'),
            'tipo'        => 'egreso',
            'monto'       => $request->input('monto'),
        ]);

        return redirect()->route('fondo_fijo.index', ['id_empresa' => $request->id_empresa])->with('pagoAgregado', 'pagoAgregado');
    }

    public function reembolso(Request $request){
        //Comprobar si la cuenta existe.
        $existe_cuenta = DB::table('banco_balance_total')->where('numero_de_cuenta', $request->cuenta)->exists();

        if($existe_cuenta){
            //Actualizar según fondo max
            $fondo_max = DB::table('fondo_fijo_totales')->where('id_empresa', $request->id_empresa)->value('fondo_max');
            $fondo_actual = DB::table('fondo_fijo_totales')->where('id_empresa', $request->id_empresa)->value('fondos');
            $fondo_banco = DB::table('banco_balance_total')->where('id_empresa', $request->id_empresa)->value('balance');

            //Verificar si se cuenta con el suficiente saldo en banco para abastecer caja chica.
            if( ($fondo_max - $fondo_actual) > $fondo_banco ){
                return redirect()->back()->with('MontoBancoInsuficiente', 'MontoBancoInsuficiente');
            }

            //Verificar si se ha gastado al menos el 60% de lo que hay en fondo fijo.
            $porcentajeGastado = (($fondo_max - $fondo_actual) / $fondo_max) * 100;

            if($porcentajeGastado >= 60){

                //Verificar si el número de cuenta pertenece a la emrpesa
                $numero_cuenta = DB::table('banco_balance_total')->where('id_empresa', $request->id_empresa)->value('numero_de_cuenta');

                if( $request->cuenta == $numero_cuenta ){
                    //Actualizar mi fondo fijo total.
                    DB::table('fondo_fijo_totales')->where('id_empresa', $request->id_empresa)->update([
                        'fondos'     => $fondo_max,
                        'updated_at' => Carbon::now()
                    ]);
        
                    //Insertar registro en la tabla de fondo fijo para llevarlo de entrada.
                    FondoFijo::create([
                        'id_empresa'  => $request->id_empresa,
                        'descripcion' => 'Reembolso de fondo fijo / caja chica',
                        'tipo'        => 'ingreso',
                        'monto'       => $fondo_max - $fondo_actual,
                    ]);
        
                    //Actualizar registro para banco total.
                    DB::table('banco_balance_total')->where('id_empresa', $request->id_empresa)->update([
                        'balance'    => $fondo_banco - ($fondo_max - $fondo_actual),
                        'updated_at' => Carbon::now()
                    ]);
        
                    //Crear registro en banco.
                    Banco::create([
                        'id_empresa' => $request->id_empresa,
                        'operacion'  => 'Retiro de dinero para caja chica',
                        'balance'    => $fondo_max - $fondo_actual,
                    ]);

                    //Crear registro en caja general
                    Caja_general::create([
                        'id_empresa'  => $request->id_empresa,
                        'descripcion' => 'Reembolso de fondo fijo / caja chica',
                        'monto'       => $fondo_max - $fondo_actual,
                        'tipo'        => 'ingreso',
                    ]);
        
                    return redirect()->route('fondo_fijo.index', ['id_empresa' => $request->id_empresa])->with('reembolsoHecho','reembolsoHecho');
                }else{
                    return redirect()->back()->with('noEsTuNumero', 'noEsTuNumero');
                }
            }else{
                return redirect()->back()->with('noGastoNecesario', 'noGastoNecesario');
            }
        }else{
            return redirect()->back()->with('noExisteCuenta', 'noExisteCuenta');
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
