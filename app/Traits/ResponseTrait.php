<?php

namespace App\Traits;

trait ResponseTrait
{
    public function successResponse($data = [], $message = 'Success', $status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json(['status' => 'success', 'data' => $data, 'message' => $message], $status);
    }

    public function errorResponse($message = 'Error', $status = 400): \Illuminate\Http\JsonResponse
    {
        return response()->json(['status' => 'fail', 'data' => [], 'message' => $message], $status);
    }

}
