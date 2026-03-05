<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');


Route::get('/login/{tipo}', [AuthController::class, 'mostrarLogin'])->name('login'); //Ruta para mostrar login segun el tipo
Route::post('/login/{tipo}', [AuthController::class, 'iniciarSesion'])->name('login.submit'); //Ruta para realizar el login segun el tipo

Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro'); //Ruta para mostrar el registro (solo clientes)
Route::post('/registro', [ClienteController::class, 'guardarClienteBD'])->name('register.submit'); //Ruta para procesar el formulario de registro

//Rutas una vez logueado del cliente
Route::get('/cliente/inicio', [ClienteController::class, 'cargarPanelCliente'])->name('cliente.inicio');
Route::get('/cliente/editar', [ClienteController::class, 'mostrarFormularioEditar'])->name('cliente.editar'); //Ruta para mostrar el formulario de editar perfil
Route::put('/cliente/editar', [ClienteController::class, 'actualizarClienteBD'])->name('cliente.update'); //Ruta para procesar la actualizacion del perfil
Route::get('/cliente/generarFactura/{id}', [ClienteController::class, 'generarFactura'])->name('cliente.generarFactura'); //Ruta para generar la factura
Route::get('/cliente/incidencia', [ClienteController::class, 'mostrarFormularioIncidencia'])->name('cliente.incidencia.create'); //Ruta para mostrar el formulario de incidencia
Route::post('/cliente/incidencia', [ClienteController::class, 'guardarIncidenciaBD'])->name('cliente.incidencia.store'); //Ruta para procesar la incidencia


//Rutas una vez logueado del trabajador
Route::get('/trabajador/inicio', function() { return view('trabajador.inicio'); })->name('trabajador.inicio');