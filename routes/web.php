<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SesionControlador;
use App\Http\Controllers\Auth\RegistroControlador;

use App\Http\Controllers\Inicios\InicioEstudianteController;

use App\Http\Controllers\EmpresaController;

use App\Http\Controllers\Index\IndexEstudianteController;

use App\Http\Controllers\Empleados\EmpleadosController;


use App\Http\Controllers\FondoFijoController;
use App\Http\Controllers\BancoController;

Route::get('/', function () {
    return view('sesion.inicio');
});

// Rutas inicio sesión ESTUDIANTE
Route::get('/login/alumno', [SesionControlador::class, 'iniciarEstudiante'])->name('login.estudiante');
Route::post('/login-alumno', [SesionControlador::class, 'loginEstudiante'])->name('inicio.estudiante');

// Rutas inicio sesión PROFESOR
Route::get('/login/profesor', [SesionControlador::class, 'iniciarProfesor'])->name('login.profesor');
Route::post('/login-profesor', [SesionControlador::class, 'loginProfesor'])->name('inicio.profesor');

// Ruta CERRAR SESION
Route::post('/logout', [SesionControlador::class, 'logout'])->name('logout');

// Rutas para registrarse
Route::get('/registrar', [RegistroControlador::class, 'showRegistrationForm'])->name('registro');
Route::post('/register-estudiante', [RegistroControlador::class, 'registerEstudiante'])->name('registro.estudiante');

//Ruta para seleccionar empresa
Route::get('/seleccion/estudiante', [InicioEstudianteController::class, 'mostrarInicio'])->name('home.estudiante');

// Rutas para empresas
Route::resource('empresas', EmpresaController::class);


//Rutas para Empezar a trabajar el estudiante con la nomina luego de seleccionar la empresa
Route::get('/index/estudiante', [IndexEstudianteController::class, 'mostrarIndexEstudiante'])->name('index.estudiante');

//Rutas para empleados
route::resource('empleados', EmpleadosController::class);

route::get('empleados/inicio/{empresa_id}', [EmpleadosController::class, 'index'])->name('empleados.index');

//Rutas para Fondo fijo.
Route::resource('fondo_fijo', FondoFijoController::class);
Route::get('fondo_fijo/apertura/', [FondoFijoController::class, 'create'])->name('fondo_fijo.create');
Route::post('fondo_fijo/apertura/', [FondoFijoController::class, 'montoApertura'])->name('fondo_fijo.montoApertura');

//Rutas para Banco.
Route::resource('banco', BancoController::class);