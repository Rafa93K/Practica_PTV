<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function store(Request $request) {
        //Validar los datos que vienen del formulario registro.blade.php
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => 'required|string|max:9|unique:clientes,dni',
            'email' => 'required|string|email|max:255|unique:clientes,email',
            'telefono' => 'required|string|max:9',
            'password' => 'required|string|min:8',
        ]);

        //Crear el cliente en la base de datos
        Cliente::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellidos,
            'dni' => $request->dni,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'contraseña' => $request->password,
        ]);

        //Redirigir con mensaje de exito
        return redirect()->route('login', 'cliente')->with('success', '¡Registro completado! Ya puedes iniciar sesión.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Por ahora vacío para futuras implementaciones
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Por ahora vacío para futuras implementaciones
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Por ahora vacío para futuras implementaciones
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Por ahora vacío para futuras implementaciones
    }
}
