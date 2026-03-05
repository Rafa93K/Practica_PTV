<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\TrabajadorController;


Route::get('/', function () {
    return view('inicio');
})->name('inicio');


Route::get('/login/{tipo}', [AuthController::class, 'showLogin'])->name('login'); //Ruta para mostrar login segun el tipo
Route::post('/login/{tipo}', [AuthController::class, 'login'])->name('login.submit'); //Ruta para realizar el login segun el tipo

Route::get('/registro', [AuthController::class, 'showRegister'])->name('registro'); //Ruta para mostrar el registro (solo clientes)
Route::post('/registro', [ClienteController::class, 'store'])->name('register.submit'); //Ruta para procesar el formulario de registro

//Rutas una vez logueado
Route::get('/cliente/inicio', [ClienteController::class, 'index'])->middleware('checklogin')->name('cliente.panelCliente'); //Ruta para el panel del cliente, protegida por el middleware de autenticación

Route::get('/manager/inicio', function () { return view('manager.inicio');})->middleware(['checklogin','role:manager'])->name('manager.inicio');

Route::get('/marketing/inicio', function () {   return view('marketing.inicio');})->middleware(['checklogin','role:marketing'])->name('marketing.inicio');

Route::get('/jefe_tecnico/inicio', function () {return view('jefe_tecnico.inicio');})->middleware(['checklogin','role:jefe_tecnico'])->name('jefe_tecnico.inicio');

Route::get('/tecnico/inicio', function () { return view('tecnico.inicio');})->middleware(['checklogin','role:tecnico'])->name('tecnico.inicio'); 



//Ruta para el manager
Route::get('/manager/crear-trabajador',[TrabajadorController::class,'crearTrabajador'])->middleware(['checklogin','role:manager'])->name('manager.crearTrabajador');
Route::post('/manager/crear-trabajador', [TrabajadorController::class, 'trabajadorSubmit'])->middleware(['checklogin','role:manager'])->name('manager.trabajadorSubmit');
