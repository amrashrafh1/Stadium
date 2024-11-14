<?php

namespace App\Http\Requests\Api\Client;

use App\Http\Requests\Api\RequestBaseAPI;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends RequestBaseAPI
{

    public function rules(): array
    {
        return [
            'name'     => 'required|string|between:2,100',
            'email'    => ['required', 'string', 'email', 'max:100', Rule::unique('users')->where(function ($query) {
                return $query->where('role', 'client')->where('deleted_at', null);
            })],
            'password' => ['required', 'string', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols(), 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => __('error.loginFailed'),
            'mobile.required'   => __('error.loginFailed'),
            'password.required' => __('error.loginFailed')
        ];
    }
}
