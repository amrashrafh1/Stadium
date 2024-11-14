<?php

namespace App\Http\Requests\Api\Client;

use App\Http\Requests\Api\RequestBaseAPI;

class AvailableSlotRequest extends RequestBaseAPI
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pitch_id' => 'required|exists:pitches,id',
            'date'     => 'required|date_format:Y-m-d',
        ];
    }

}
