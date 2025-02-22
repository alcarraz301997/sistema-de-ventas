<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

        /**
     * @param array|null $data
     * @param string $message = ''
     * @param int $status = 200
     * @param array $headers
     */
    protected function response($data = null, string $message = '', int $status = 200) {
        $response = [
            'success' => true,
            'type' => 'success',
            'mesage' => $message,
            'data' => $data
        ];

        return response()->json($response, $status);
    }
}
