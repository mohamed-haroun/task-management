<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponses
{
    public function success($data = [], $message = 'Request was successfully processed', $code = 200): JsonResponse
    {
        return response()->json([
            'status' => "success",
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function error($data = [], $message = 'error', $code = 400): JsonResponse
    {
        return response()->json([
            'status' => "Request was not processed",
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
