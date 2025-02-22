<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $authData    = $this->authService->login($credentials['email'], $credentials['password']);

        if (!$authData) {
            return $this->response(null, 'Credenciales incorrectas.', 401);
        }

        return $this->response($authData, 'Inicio de sesión exitoso.');
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return $this->response(null, 'Sesión cerrada correctamente.');
    }
}
