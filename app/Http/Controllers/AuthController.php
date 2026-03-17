<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\DynamicRequestValidator;

class AuthController extends Controller {
    private AuthService $authService;

    /**
     * @param AuthService $authService
     * @return void
     * @author Rafael Osuna
     * @description Inyecta el servicio de autenticación.
     */
    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }
    
    /**
     * @param $tipo
     * @return \Illuminate\View\View
     * @author Rafael Osuna
     * @description Muestra la vista de login con el tipo de usuario que se pase como parámetro.
     */
    public function mostrarLogin($tipo) {
        //Validar que solo existan cliente o trabajador
        if (!in_array($tipo, ['cliente', 'trabajador'])) {
            abort(404); //Error 404
        }

        //Vamos al login con el tipo que hayamos
        return view('auth.login', compact('tipo'));
    }

    /**
     * @return \Illuminate\View\View
     * @author Rafael Osuna
     * @description Muestra la vista de registro.
     */
    public function mostrarRegistro() {
        return view('auth.registro');
    }

    /**
     * @param DynamicRequestValidator $request
     * @param $tipo
     * @return \Illuminate\Http\RedirectResponse
     * @author Rafael Osuna
     * @description Valida los datos del formulario y inicia sesión con el usuario que se pase como parámetro.
     */
    public function iniciarSesion(DynamicRequestValidator $request, $tipo) {
        return $this->authService->login($request, $tipo);
    }
}