<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empresa;
use App\Models\EstudianteEmpresa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmpresaController extends Controller
{
    /**
     * Muestra el formulario de creación para una nueva empresa.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Generar una lista de logos predefinidos
        $logos = $this->getLogos();

        return view('empresa.create', compact('logos'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate(Empresa::rules());

        $estudiante = Auth::user();

        //dd($estudiante->id);
        // Crear la nueva empresa utilizando el modelo.
        $empresa = Empresa::create([
            'estudiante_id' => $estudiante->id,
            'nombre' => $request->input('nombre'),
            'logo' => $request->input('logo'),
            'rubro' => $request->input('rubro'),
            'direccion' => $request->input('direccion'),
            'telefono' => $request->input('telefono'),
        ]);

        EstudianteEmpresa::create([
            'estudiante_id' => $estudiante->id,
            'empresa_id' => $empresa->id
        ]);

        //Generar registro de caja general.
        /*DB::table('caja_general_total')->insert([
            'id_empresa' => $empresa->id,
            'fondos'     => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);*/

        // Redirigir al inicio del estudiante con un mensaje de éxito
        return redirect()->route('home.estudiante')->with('EmpresaCreada', 'EmpresaCreada');
    }

    /**
     * Muestra el formulario para editar una empresa existente.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\View\View
     */
    public function edit(Empresa $empresa)
    {
        // Generar una lista de logos predefinidos
        $logos = $this->getLogos();

        return view('empresa.edit', compact('empresa', 'logos'));
    }

    /**
     * Actualiza una empresa existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Empresa $empresa)
    {
        // Validar los datos del formulario
        $request->validate(Empresa::rules());

        // Actualizar la empresa utilizando el modelo
        $empresa->update([
            'nombre' => $request->input('nombre'),
            'logo' => $request->input('logo'),
            'rubro' => $request->input('rubro'),
            'direccion' => $request->input('direccion'),
            'telefono' => $request->input('telefono'),
        ]);

        // Redirigir al inicio del estudiante con un mensaje de éxito
        return redirect()->route('home.estudiante')->with('actualizarEmpresa', 'actualizarEmpresa');
    }

    /**
     * Obtiene la lista de logos predefinidos.
     *
     * @return array
     */
    private function getLogos()
    {
        $logos = [];
        for ($i = 1; $i <= 19; $i++) {
            $logos[] = [
                'path' => "logos/{$i}.svg",
                'url' => asset("storage/logos/{$i}.svg"),
            ];
        }

        return $logos;
    }

    //Función para destruir una empresa.
    public function destroy($id){
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();

        return redirect()->route('home.estudiante')->with('empresaEliminada', 'empresaEliminada');
    }
}
