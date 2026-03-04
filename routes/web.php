<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

//Ruta para mostrar login segun el tipo
Route::get('/login/{tipo}', [AuthController::class, 'showLogin'])->name('login');

Route::get('/registro', [AuthController::class, 'showRegister'])->name('registro'); //Ruta para mostrar el registro (solo clientes)
Route::post('/registro', [ClienteController::class, 'store'])->name('register.submit'); //Ruta para procesar el formulario de registro