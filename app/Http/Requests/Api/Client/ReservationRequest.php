<?php

namespace App\Http\Requests\API\Client;

use App\Http\Requests\Api\RequestBaseAPI;

class ReservationRequest extends RequestBaseAPI
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        switch ($this->method()) {
            case 'GET':
                return [
                    'is_paginated'     => 'sometimes|nullable|boolean',
                    'public_search'    => 'sometimes|nullable|string|max:255',
                    'reservation_date' => 'sometimes|nullable|date',
                    'barber_id'        => 'sometimes|nullable|exists:barbers,id',
                    'orderBy'          => 'sometimes|nullable|string|in:reservation_date,created_at,id,user.name,user.mobile',
                    'orderType'        => 'sometimes|nullable|string|in:ASC,DESC',
                    'user.name'        => 'sometimes|nullable|string|max:255',
                    'user.mobile'      => 'sometimes|nullable|string|max:255'
                ];
            case 'POST':
                return [
                    'date'     => 'required|date_format:Y-m-d',
                    'pitch_id' => 'required|exists:pitches,id',
                    'slot_id'  => 'required|exists:slots,id',
                    'period'   => 'required|in:60,90',
                ];

            case 'PUT':
                return [
                ];

            default:
                break;
        }

    }

}
