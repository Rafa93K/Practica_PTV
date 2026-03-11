<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole {
    public function handle(Request $request, Closure $next, $role)
    {
        if (session('user_role') !== $role) {
            abort(403, 'No tienes permisos para acceder.');
        }

        return $next($request);
    }
}