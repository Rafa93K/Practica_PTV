<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('inicio');
});

//Mostrar login segun tipo
Route::get('/login/{tipo}', [AuthController::class, 'showLogin'])->name('login');

//Mostrar registro (solo cliente)
Route::get('/registro', [AuthController::class, 'showRegister'])->name('registro');