<?php

namespace App\Http\Controllers;

use App\Models\FondoFijo;
use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FondoFijoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::find($request->empresa_id);
        $pagos = FondoFijo::where('id_empresa', $empresa->id)->get();

        //Si no hay ningún pago, entonces se redirige a crear la apertura de caja chica.
        if($pagos->isEmpty()){
            return view('fondo_fijo.create', compact('empresa'));
        }

        $fondo_actual = DB::table('fondo_fijo_totales')->where('id_empresa', $empresa->id)->value('fondos');

        return view('fondo_fijo.index', compact('empresa', 'pagos', 'fondo_actual'));
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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        //Insertar registro en la tabla de pagos para llevarlo de entrada.
        DB::table('fondo_fijos')->insert([
            'id_empresa'=> $request->id_empresa,
            'descripcion_de_operacion' => 'Apertura de fondo fijo / caja chica',
            'tipo' => 'ingresos',
            'monto' => $request->input('monto'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $empresa = Empresa::find($request->id_empresa);
        $fondo_actual = DB::table('fondo_fijo_totales')->where('id_empresa', $empresa->id_empresa)->value('fondos');
        $pagos = FondoFijo::where('id_empresa', $empresa->id_empresa)->get();

        return to_route('fondo_fijo.index', ['fondo_actual'=> $fondo_actual, 'pagos'=> $pagos, 'empresa'=> $empresa, 'empresa_id' => $request->id_empresa])->with('guardadoApertura','guardadoApertura');
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
        if($request->input('tipo') == 'ingresos'){
            $fondo_actual = DB::table('fondo_fijo_totales')->where('id_empresa', $request->id_empresa)->value('fondos');
            $fondo_actual = $fondo_actual + $request->input('monto');

            DB::table('fondo_fijo_totales')->where('id_empresa', $request->id_empresa)->update([
                'fondos'=> $fondo_actual,
                'updated_at' => Carbon::now()
            ]);
        }else{
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
        }

        FondoFijo::create([
            'id_empresa' => $request->id_empresa,
            'descripcion_de_operacion' => $request->input('OP'),
            'tipo' => $request->input('tipo'),
            'monto' => $request->input('monto'),
        ]);

        return redirect()->route('fondo_fijo.index', ['empresa_id' => $request->id_empresa])->with('pagoAgregado', 'pagoAgregado');
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
