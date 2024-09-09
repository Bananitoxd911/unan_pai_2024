<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

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

    /**
     * Guarda una nueva empresa en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate(Empresa::rules());

        $estudiante = Auth::user();

        // Crear la nueva empresa utilizando el modelo, se guarda en una variable para su posterior uso.
        $empresa = Empresa::create([
            'id_estudiante' => $estudiante->id,
            'nombre' => $request->input('nombre'),
            'logo' => $request->input('logo'),
            'rubro' => $request->input('rubro'),
            'direccion' => $request->input('direccion'),
            'telefono' => $request->input('telefono'),
        ]);

        //Cada vez que la empresa se cree, se le abonara un fondo fijo predeterminado, por ahora.
        DB::table('fondo_fijo_totales')->insert([
            'id_empresa' => $empresa->id,
        ]);

        // Redirigir al inicio del estudiante con un mensaje de éxito
        return redirect()->route('home.estudiante')->with('success', 'Empresa registrada con éxito.');
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
        return redirect()->route('home.estudiante')->with('success', 'Empresa actualizada con éxito.');
    }

    /**
     * Obtiene la lista de logos predefinidos.
     *
     * @return array
     */
    private function getLogos()
    {
        $logos = [];
        for ($i = 1; $i <= 14; $i++) {
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

        return redirect()->route('home.estudiante')->with('success', 'Empresa eliminada con éxito.');
    }
}
