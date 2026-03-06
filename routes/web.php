<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\ProductoController;


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
Route::get('/cliente/tarifas', [ClienteController::class, 'verTarifas'])->name('cliente.tarifas'); //Ruta para ver las tarifas disponibles
Route::get('/cliente/contratarTarifa/{id}', [ClienteController::class, 'contratarTarifa'])->name('cliente.contratarTarifa'); //Ruta para contratar tarifa


//RUTAS POR ROL DE TRABAJADOR
Route::get('/manager/inicio', function () { return view('manager.inicio');})->middleware(['checklogin','role:manager'])->name('manager.inicio');
Route::get('/marketing/inicio', function () {   return view('marketing.inicio');})->middleware(['checklogin','role:marketing'])->name('marketing.inicio');
Route::get('/jefe_tecnico/inicio', function () {return view('jefe_tecnico.inicio');})->middleware(['checklogin','role:jefe_tecnico'])->name('jefe_tecnico.inicio');
Route::get('/tecnico/inicio', function () { return view('tecnico.inicio');})->middleware(['checklogin','role:tecnico'])->name('tecnico.inicio'); 



//RUTAS MANAGER
//creacion de trabajador
Route::get('/manager/crear-trabajador',[TrabajadorController::class,'crearTrabajador'])->middleware(['checklogin','role:manager'])->name('manager.crearTrabajador');
Route::post('/manager/crear-trabajador', [TrabajadorController::class, 'trabajadorSubmit'])->middleware(['checklogin','role:manager'])->name('manager.trabajadorSubmit');
//Creación de producto
Route::get('/manager/productos',[ProductoController::class,'mostrarProducto'])->middleware(['checklogin','role:manager'])->name('mostrarProducto');
Route::post('/manager/productos',[ProductoController::class,'guardarProducto'])->middleware(['checklogin','role:manager'])->name('productoSubmit');