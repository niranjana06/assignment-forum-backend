<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{

    protected function respond($data, $statusCode = 200, $headers = [])
    {
        return response()->json($data, $statusCode, $headers);
    }

    protected function respondSuccess($data, $statusCode = 200, $headers = [])
    {
        return $this->respond([
            'status' => true,
            'data' => $data
        ], $statusCode, $headers);
    }

    protected function respondError($message, $status, $code = '')
    {
        return $this->respond([
            'success' => false,
            'error' => [
                'message' => $message,
                'status' => $status,
                'code' => $code
            ]
        ], $status);
    }

    protected function respondUnauthorized($message = 'Unauthorized')
    {
        return $this->respondError($message, 401);
    }

    protected function respondInternalError($message = 'Internal Error')
    {
        return $this->respondError($message, 500);
    }

}
