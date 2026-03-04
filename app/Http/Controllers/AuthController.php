<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Trabajadore;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function showLogin($tipo) {
        //Validar que solo existan cliente o trabajador
        if (!in_array($tipo, ['cliente', 'trabajador'])) {
            abort(404); //Error 404
        }

        //Vamos al login con el tipo que hayamos
        return view('auth.login', compact('tipo'));
    }

    public function showRegister() {
        return view('auth.registro');
    }

    public function login(Request $request, $tipo) {
        //Validar los datos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Introduce un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        //Buscar el usuario segun el tipo
        if ($tipo === 'cliente') {
            $user = Cliente::where('email', $request->email)->first();
        } else {
            $user = Trabajadore::where('email', $request->email)->first();
        }

        //Verificar si existe y si la contraseña es correcta
        if ($user && Hash::check($request->password, $user->contraseña)) {
            //Guardar algo en sesión para "simular" el login por ahora
            session([
                'user_id' => $user->id, 
                'user_type' => $tipo,
                'user_name' => $user->nombre
                ]);

            //Redirigir al inicio correspondiente
            return redirect()->route($tipo . '.inicio');
        }

        //Si fallan las credenciales
        return back()->withErrors(['email' => 'El correo o la contraseña son incorrectos.'])->withInput();
    }
}