<?php

namespace App\Http\Requests\Api\Client;

use App\Http\Requests\Api\RequestBaseAPI;

class LoginRequest extends RequestBaseAPI
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'email'        => 'required|string',
            'password'     => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'mobile.required'   => __('error.loginFailed'),
            'password.required' => __('error.loginFailed')
        ];
    }

}
