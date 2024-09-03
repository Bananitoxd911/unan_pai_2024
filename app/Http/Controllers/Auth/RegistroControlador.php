<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Profesor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegistroControlador extends Controller
{
        // Mostrar formulario de registro
        public function showRegistrationForm()
        {
            return view('registro.registrar');
        }
    
        // Registro de estudiantes
        public function registerEstudiante(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'carnet' => 'required|string|unique:estudiantes,carnet|max:12',
                'pin' => 'required|string|size:6',
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $estudiante = Estudiante::create([
                'carnet' => $request->carnet,
                'pin' => $request->pin,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
            ]);
    
            return redirect()->route('login.estudiante')->with('success', 'Registro de estudiante exitoso.');
        }
    

}
