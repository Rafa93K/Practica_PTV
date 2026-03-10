<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Requests\DynamicRequestValidator;

class CheckLogin
{
    public function handle(DynamicRequestValidator $request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login', 'cliente');
        }

        return $next($request);
    }
}