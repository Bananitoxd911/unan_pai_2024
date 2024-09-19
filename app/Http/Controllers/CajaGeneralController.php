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
        $empresa = Empresa::find($request->id_empresa);
        $registros = Caja_general::where('id_empresa', $empresa->id)->get();

        $fondo_actual = DB::table('caja_general_total')->where('id_empresa', $empresa->id)->value('fondos');
    
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
        //Lógica de pagos para caja chica.
        if($request->input('tipo') == 'ingreso'){

            $existe_empresa = DB::table('caja_general_total')->where('id_empresa', $request->id_empresa)->exists();
            if(!$existe_empresa){
                DB::table('caja_general_total')->insert([
                    'id_empresa' => $request->id_empresa,
                    'fondos'     => $request->input('monto'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }else{
                $fondo_actual = DB::table('caja_general_total')->where('id_empresa', $request->id_empresa)->value('fondos');
                $fondo_actual = $fondo_actual + $request->input('monto');

                DB::table('caja_general_total')->where('id_empresa', $request->id_empresa)->update([
                    'fondos'     => $fondo_actual,
                    'updated_at' => Carbon::now()
                ]);
            }
        }else{
            $fondo_actual = DB::table('caja_general_total')->where('id_empresa', $request->id_empresa)->value('fondos');

            //Verificar si puede hacerse el egreso.
            if($fondo_actual < $request->monto){
                return redirect()->back()->with('DemaciadoParaEgreso', 'DemaciadoParaEgreso');
            }

            $fondo_actual = $fondo_actual - $request->input('monto');

            DB::table('caja_general_total')->where('id_empresa', $request->id_empresa)->update([
                'fondos'     => $fondo_actual,
                'updated_at' => Carbon::now()
            ]);
        }

        //Generar el registro.
        Caja_general::create([
            'id_empresa'  => $request->id_empresa,
            'descripcion' => $request->input('OP'),
            'tipo'        => $request->input('tipo'),
            'monto'       => $request->input('monto'),
        ]);

        return redirect()->route('caja_general.index', ['id_empresa' => $request->id_empresa])->with('RegistroGuardado', 'RegistroGuardado');
    }

    public function abono(Request $request){
         
        //Comprobar si la cuenta existe.
        $existe_cuenta = DB::table('banco_balance_total')->where('numero_de_cuenta', $request->cuenta)->exists();

        if($existe_cuenta){
            //Verificar si el número de cuenta pertenece a la emrpesa
            $numero_cuenta = DB::table('banco_balance_total')->where('id_empresa', $request->id_empresa)->value('numero_de_cuenta');

            if( $request->cuenta == $numero_cuenta ){

                // Obtener el fondo en mi banco.
                $fondo_banco = DB::table('banco_balance_total')->where('id_empresa', $request->id_empresa)->value('balance');

                // Obtener el fondo de mi caja general.
                $fondo_general = DB::table('caja_general_total')->where('id_empresa', $request->id_empresa)->value('fondos');

                 // Actualizar registro para banco total.
                DB::table('banco_balance_total')->where('id_empresa', $request->id_empresa)->update([
                    'balance'    => $request->monto + $fondo_banco,
                    'updated_at' => Carbon::now()
                ]);

                // Actualizar fondo en caja general.
                DB::table('caja_general_total')->where('id_empresa', $request->id_empresa)->update([
                    'fondos'     => $fondo_general - $request->monto,
                    'updated_at' => Carbon::now()
                ]);

                //Crear registro en banco.
                Banco::create([
                    'id_empresa' => $request->id_empresa,
                    'operacion'  => 'Abono de dinero desde caja general',
                    'balance'    => $request->monto,
                ]);

                //Crear registro en caja general.
                Caja_general::create([
                    'id_empresa'  => $request->id_empresa,
                    'descripcion' => 'Abono de dinero para banco',
                    'monto'       => $request->monto,
                    'tipo'        => 'egreso',
                ]);

                return redirect()->route('caja_general.index', ['id_empresa' => $request->id_empresa])->with('abonoHecho','abonoHecho');

            }else{
                return redirect()->back()->with('noEsTuNumero', 'noEsTuNumero');
            }
        }else{
            return redirect()->back()->with('noExisteCuenta', 'noExisteCuenta');
        }
    
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
    public function destroy_all(){
        Caja_general::truncate();
        FondoFijo::truncate();
        Banco::truncate();
        DB::table('fondo_fijo_totales')->truncate();
        DB::table('banco_balance_total')->truncate();
        DB::table('caja_general_total')->truncate();
        
        return redirect()->route('home.estudiante');
    }
}
