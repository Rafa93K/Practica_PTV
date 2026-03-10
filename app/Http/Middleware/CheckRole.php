<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Requests\DynamicRequestValidator;

class CheckRole
{
    public function handle(DynamicRequestValidator $request, Closure $next, $role)
    {
        if (session('user_role') !== $role) {
            abort(403, 'No tienes permisos para acceder.');
        }

        return $next($request);
    }
}