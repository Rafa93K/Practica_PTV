<?php

namespace App\Services;
use App\Models\Cliente;
use App\Models\Trabajadore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService {
    public function login(Request $request, $tipo) {
        //Buscar el usuario segun el tipo
        if ($tipo === 'cliente') {
            $user = Cliente::where('email', $request->email)->first();
        } else {
            $user = Trabajadore::where('email', $request->email)->first();
        }

        //Verificar si existe y si la contraseña es correcta
        if ($user && Hash::check($request->password, $user->contraseña)) {
            session(['user_id' => $user->id, 'user_type' => $tipo]);

            //Redirigir al inicio correspondiente
            return redirect()->route($tipo . '.inicio');
        }

        //Si fallan las credenciales
        return back()->withErrors(['email' => 'El correo o la contraseña son incorrectos.'])->withInput();
    }
}