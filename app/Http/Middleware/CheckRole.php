<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole {
    public function handle(Request $request, Closure $next, ...$roles)
    {
        //Comprobamos si el rol del usuario esta dentro de la lista de roles permitidos
        if (!in_array(session('user_role'), $roles)) {
            abort(403, 'No tienes permisos para acceder.');
        }

        return $next($request);
    }
}