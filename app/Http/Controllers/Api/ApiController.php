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

}
