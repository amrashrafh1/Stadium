<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Requests\Api\RequestBaseAPI;

class VerifyOtpRequest extends RequestBaseAPI
{

    public function rules(): array {
        return [
            'email'  => 'required|string|email|exists:users,email,role,client',
            'otp'    => 'required|max:4',
        ];
    }
}
