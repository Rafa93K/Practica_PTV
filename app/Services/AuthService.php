<?php

namespace App\Services;
use App\Models\Cliente;
use App\Models\Trabajadore;
use App\Http\Requests\DynamicRequestValidator;
use Illuminate\Support\Facades\Hash;

class AuthService {
    public function login(DynamicRequestValidator $request, $tipo) {
        //Buscar el usuario segun el tipo
        if ($tipo === 'cliente') {
            $user = Cliente::where('email', $request->email)->first();
        } else {
            $user = Trabajadore::where('email', $request->email)->first();
        }

        //Verificar si existe y si la contraseña es correcta
        if ($user && Hash::check($request->password, $user->contraseña)) {
            session([
                'user_id' => $user->id, 
                'user_type' => $tipo,
                'user_name' => $user->nombre,
                'user_role' => $user->rol ?? null
            ]);

            //Redirigir al inicio correspondiente
            if ($tipo === 'cliente') {
                return redirect()->route('cliente.inicio');
            }

            // Si es trabajador, redirigir según su rol
            if ($user->rol) {
                return redirect()->route($user->rol . '.inicio');
            }

            return redirect()->route('inicio');
        }


        //Si fallan las credenciales
        return back()->withErrors(['email' => 'El correo o la contraseña son incorrectos.'])->withInput();
    }
}