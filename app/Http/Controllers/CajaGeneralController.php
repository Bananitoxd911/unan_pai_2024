<?php

namespace App\Http\Controllers;

use App\Models\Caja_general;
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
                    'fondos' => $request->input('monto'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }else{
                $fondo_actual = DB::table('caja_general_total')->where('id_empresa', $request->id_empresa)->value('fondos');
                $fondo_actual = $fondo_actual + $request->input('monto');

                DB::table('caja_general_total')->where('id_empresa', $request->id_empresa)->update([
                    'fondos'=> $fondo_actual,
                    'updated_at' => Carbon::now()
                ]);
            }
        }else{
            $fondo_actual = DB::table('caja_general_total')->where('id_empresa', $request->id_empresa)->value('fondos');
            $fondo_actual = $fondo_actual - $request->input('monto');

            DB::table('caja_general_total')->where('id_empresa', $request->id_empresa)->update([
                'fondos'=> $fondo_actual,
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
