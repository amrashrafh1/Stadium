<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class RequestBaseAPI extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function expectsJson(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        $data['status'] = "validation_errors";
        $data['error'] = $validator->errors()->first();
        throw new HttpResponseException(response()->json([
            'status' => $data['status'],
            'data' => [],
            'message' => $data['error'],
            'errors' => $data['error']
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)); // 422
    }
}
