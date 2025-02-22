<?php

namespace App\Http\Middleware;

use App\Constans\Error;
use App\Exceptions\ResponseException;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Maneja una solicitud entrante.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if ($this->authenticate($request, $guards) === false) {
            return $this->unauthenticated($request, $guards);
        }

        return $next($request);
    }

    /**
     * Maneja la respuesta para usuarios no autenticados.
     */
    protected function unauthenticated($request, array $guards)
    {
        return throw new ResponseException(Error::TOKEN_EXPIRED, 'No autenticado. Inicie sesión para continuar.');
    }
}
