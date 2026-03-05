<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;

class ClienteService {
    public function comprobarUsuario() {
        //Comprueba que el usuario que intenta acceder es un cliente
        $clienteId = session('user_id');
        $userType = session('user_type');

        //Si no es un cliente o no existe, lo devolvemos a la pagina de login
        if (!$clienteId || $userType !== 'cliente') {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Debes iniciar sesion como cliente']);
        }

        return $clienteId; //Devolvemos el ID del cliente
    }

    public function crearCliente(Request $request) {
        //Crear el cliente
        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
        ]);

        return $cliente; //Devolvemos el cliente creado
    }

    public function actualizarCliente(Request $request) {
        $clienteId = $this->comprobarUsuario();
        $cliente = Cliente::find($clienteId);
        
        //Actualizar solo email y teléfono
        $cliente->email = $request->email;
        $cliente->telefono = $request->telefono;
        $cliente->save();

        return $cliente; //Devolvemos el cliente actualizado
    }
}