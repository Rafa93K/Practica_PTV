<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
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
}