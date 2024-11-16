<?php

namespace App\Http\Resources\API\Client;

use App\Http\Resources\API\Client\User\UserResource;
use App\Http\Resources\API\Provider\User\ProviderResource;
use App\Http\Resources\API\StatusResource;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    public static function collection($data)
    {

        /* is_a() makes sure that you don't just match AbstractPaginator
         * instances but also match anything that extends that class.
         */
        if (is_a($data, \Illuminate\Pagination\AbstractPaginator::class)) {
            $data->setCollection(
                $data->getCollection()->map(function ($listing) {
                    return new static($listing);
                })
            );

            return $data;
        }

        return parent::collection($data);
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray(Request $request): array
    {

        return [
            'id'               => $this->id,
            'total'            => number_format($this->total, 2, '.', ''),
            'created_at'       => Carbon::parse($this->created_at)->format('Y-m-d h:i A'),
            'reservation_date' => $this->reservation_date->format('Y-m-d h:i A'),
            'user'             => new AuthResource($this->user),
            'pitch'            => new PitchResource($this->pitch),
        ];

    }

}
