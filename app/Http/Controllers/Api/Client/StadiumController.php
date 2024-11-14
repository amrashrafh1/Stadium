<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Resources\API\Client\StadiumResource;
use App\Models\Stadium;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class StadiumController
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $stadiums = Stadium::query();

        if ($request->is_paginated) {
            $stadiums = $stadiums->paginate(10);
        } else {
            $stadiums = $stadiums->get();
        }

        return $this->successResponse(StadiumResource::collection($stadiums));
    }
}
