<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profesor;
use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class SesionControlador extends Controller
{
        // Método para mostrar el formulario de inicio de sesión
        public function iniciarEstudiante()
        {
            return view('sesion.login_estudiante');
        }

        // Método para mostrar el formulario de inicio de sesión
        public function iniciarProfesor()
        {
            return view('sesion.login_profesor');
        }
    
        // Método para manejar el inicio de sesión de Estudiantes
        public function loginEstudiante(Request $request)
        {
            $request->validate([
                'carnet' => [
                    'required',
                    'string',
                    'size:10', // Longitud exacta de 12 caracteres
                    'regex:/^\d{2}-\d{5}-\d{1}$/', // Formato específico
                    'exists:estudiantes,carnet', // Verifica que el carnet exista en la base de datos
                ],
                'pin' => 'required|string|size:6', // Longitud exacta de 6 caracteres
            ]);
    
            $estudiante = Estudiante::where('carnet', $request->carnet)->first();
    
            if ($estudiante && $estudiante->pin === $request->pin) {
                // Iniciar sesión al estudiante
                Auth::login($estudiante);
                // Autenticación exitosa
                return redirect()->route('home.estudiante'); // Cambia 'home' por la ruta a la que deseas redirigir
            } else {
                return back()->withErrors(['pin' => 'El PIN es incorrecto.']);
            }
        }
        
        
    
        // Método para manejar el inicio de sesión de Profesores
        public function loginProfesor(Request $request)
        {
            $request->validate([
                'nombres' => 'required|string|exists:profesores,nombres',
                'contrasena' => 'required|string',
            ]);
    
            $profesor = Profesor::where('nombres', $request->nombres)->first();
    
            if ($profesor && Hash::check($request->contrasena, $profesor->contrasena)) {
                // Iniciar sesión al profesor
                Auth::login($profesor);
                return redirect()->route('dashboard.profesor');
            } else {
                return back()->withErrors(['contrasena' => 'La contraseña es incorrecta.']);
            }
        }
    
        // Método para cerrar sesión
        public function logout()
        {
            Auth::logout();
            return redirect()->route('login');
        }
}
