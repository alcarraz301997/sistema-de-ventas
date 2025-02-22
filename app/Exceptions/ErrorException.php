<?php

namespace App\Exceptions;

use App\Constans\Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ErrorException extends Exception
{
    private $httpCode;
    private $exception;
    private $type;

    public function __construct($message, $exception = null)
    {
        $this->httpCode     = Error::SERVER_ERROR;
        $this->type         = 'error';
        $this->exception  = $exception->getTrace();
        parent::__construct($message, $this->httpCode);
    }

    public function report()
    {
        Log::error($this);
    }

    public function render(Request $request) : JsonResponse
    {
        return response()->json([
            'success'   => false,
            'type'      => $this->type,
            'message'   => $this->message,
            'errors'    => $this->exception
        ], $this->httpCode);
    }
}
