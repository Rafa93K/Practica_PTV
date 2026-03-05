<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\DynamicRequestValidator;

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

    public function iniciarSesion(DynamicRequestValidator $request, $tipo) {
        return $this->authService->login($request, $tipo);
    }
}