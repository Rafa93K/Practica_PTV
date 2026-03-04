<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');


Route::get('/login/{tipo}', [AuthController::class, 'showLogin'])->name('login'); //Ruta para mostrar login segun el tipo
Route::post('/login/{tipo}', [AuthController::class, 'login'])->name('login.submit'); //Ruta para realizar el login segun el tipo

Route::get('/registro', [AuthController::class, 'showRegister'])->name('registro'); //Ruta para mostrar el registro (solo clientes)
Route::post('/registro', [ClienteController::class, 'store'])->name('register.submit'); //Ruta para procesar el formulario de registro

//Rutas una vez logueado
Route::get('/cliente/inicio', function() { return view('cliente.inicio'); })->name('cliente.inicio');
Route::get('/trabajador/inicio', function() { return view('trabajador.inicio'); })->name('trabajador.inicio');