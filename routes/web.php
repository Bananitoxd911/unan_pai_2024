<?php

use App\Http\Controllers\ArqueoCajaController;
use App\Http\Controllers\DepartamentoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SesionControlador;
use App\Http\Controllers\Auth\RegistroControlador;

use App\Http\Controllers\Inicios\InicioEstudianteController;

use App\Http\Controllers\EmpresaController;

use App\Http\Controllers\Index\IndexEstudianteController;

use App\Http\Controllers\Empleados\EmpleadosController;
use App\Http\Controllers\NominaController;


use App\Http\Controllers\FondoFijoController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\CajaGeneralController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\InformeController;

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
Route::resource('cargos', CargoController::class);

//Rutas para la nomina
Route::resource('nominas', NominaController::class);
Route::get('nominas/inicio/{empresa_id}', [NominaController::class, 'index'])->name('nominas.index');
Route::get('nominas/create/{empresa_id?}', [NominaController::class, 'create'])->name('nominas.create');

Route::get('/nomina/{nomina}/empresa/{empresa}', [NominaController::class, 'show'])->name('nominas.show');

Route::get('/informes/empleados/{empresa_id}', [InformeController::class, 'empleados'])->name('informes.empleados');


//Rutas para Empezar a trabajar el estudiante con la nomina luego de seleccionar la empresa
Route::get('/index/estudiante', [IndexEstudianteController::class, 'mostrarIndexEstudiante'])->name('index.estudiante');

//Rutas para empleados
route::resource('empleados', EmpleadosController::class);
Route::get('/nomina/empleado/{empleado}/mes/{mes}', [EmpleadosController::class, 'getNominaPorMes']);

route::get('empleados/inicio/{empresa_id}', [EmpleadosController::class, 'index'])->name('empleados.index');

//Rutas para Fondo fijo.
Route::resource('fondo_fijo', FondoFijoController::class);
Route::get('fondo_fijo/apertura/', [FondoFijoController::class, 'create'])->name('fondo_fijo.create');
Route::post('fondo_fijo/apertura/', [FondoFijoController::class, 'montoApertura'])->name('fondo_fijo.montoApertura');
Route::post('fondo_fijo/reembolso/', [FondoFijoController::class, 'reembolso'])->name('fondo_fijo.reembolso');

//Rutas para Banco.
Route::resource('banco', BancoController::class);

//Rutas para caja general.
Route::resource('caja_general', CajaGeneralController::class);
Route::post('caja_general/abono/', [CajaGeneralController::class, 'abono'])->name('caja_general.abono');

//Esto debe de ser eliminado del producto final, sirve para destruir todo.
Route::get('/funcion_destruir', [CajaGeneralController::class, 'destroy_all'])->name('destroy_all');

Route::get('/indemnizacion/inicio', [EmpleadosController::class, 'indemnizaciones'])->name('indemnizacion.calculo');


Route::get('/check-inss/{numero_inss}', [EmpleadosController::class, 'checkInss']);

Route::resource('departamentos',  DepartamentoController::class);

Route::delete('empleados/{empresa_id}/{empleado}', [EmpleadosController::class, 'destroy'])->name('empleados.destroy');


Route::get('/arqueo-caja/index', [ArqueoCajaController::class, 'index'])->name('arqueoCaja.index');