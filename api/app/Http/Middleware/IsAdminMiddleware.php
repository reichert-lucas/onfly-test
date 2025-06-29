<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->is_admin && !$request->user()->is_super_admin) {
            throw new AuthenticationException('O usuário não é um administrador');
        }

        return $next($request);
    }
}
