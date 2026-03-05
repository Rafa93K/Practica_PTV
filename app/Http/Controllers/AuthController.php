<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Trabajadore;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }
    
    public function mostrarLogin($tipo) {
        //Validar que solo existan cliente o trabajador
        if (!in_array($tipo, ['cliente', 'trabajador'])) {
            abort(404); //Error 404
        }

        //Vamos al login con el tipo que hayamos
        return view('auth.login', compact('tipo'));
    }

    public function mostrarRegistro() {
        return view('auth.registro');
    }

    public function iniciarSesion(Request $request, $tipo) {
        //Validar los datos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Introduce un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        return $this->authService->login($request, $tipo);
    }
}