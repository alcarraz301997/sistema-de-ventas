<?php

namespace App\Exceptions;

use App\Constans\Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResponseException extends Exception
{
    private $httpCode;
    private $type;
    private $data;

    public function __construct(int $httpCode = Error::CLIENT_ERROR, string $message = "Error", string $type = "warning", $data = null)
    {
        $this->httpCode = $httpCode;
        $this->type     = $type;
        $this->data     = $data;

        parent::__construct($message, $httpCode);
    }

    public function render(Request $request) : JsonResponse
    {
        return response()->json([
            'success'   => false,
            'type'      => $this->type,
            'message'   => $this->getMessage(),
            'data'      => $this->data,
        ], $this->httpCode);
    }
}
