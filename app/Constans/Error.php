<?php

namespace App\Constans;

class Error
{
    const CLIENT_ERROR = 400; // Errores del cliente
    const SERVER_ERROR = 500; // Errores del servidor
    const NOT_FOUND = 404;    // Recurso no encontrado
    const CONFLICT = 409;     // Conflicto con el estado actual del recurso
    const UNAUTHORIZED_ACCESS = 403; // Acceso no autorizado
    const TOKEN_EXPIRED = 401; // Token expirado
    const DATA_INVALIDATED = 422; // Dato inválido
}