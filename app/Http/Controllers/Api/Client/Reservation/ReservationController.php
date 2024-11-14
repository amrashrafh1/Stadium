<?php

namespace App\Http\Controllers\Api\Client\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Client\AvailableSlotRequest;
use App\Http\Requests\API\Client\ReservationRequest;
use App\Http\Resources\API\Client\ReservationResource;
use App\Models\Schedule;
use App\Services\ReservationService;
use App\Traits\ResponseTrait;

class ReservationController extends Controller
{
    use ResponseTrait;

    public function __construct(
        protected ReservationService $reservationService)
    {
    }

    public function index(ReservationRequest $request)
    {
        // get user reservations
        $reservations = auth()->user()->reservations()
            ->with('pitches', 'user')
            ->orderBy('id', 'desc');

        if ($request->is_paginated) {
            return $this->successResponse(ReservationResource::collection($reservations->paginate(10)));
        }

        return $this->successResponse(ReservationResource::collection($reservations->get()));
    }

    public function show($id)
    {
        $reservations = auth()->user()->reservations()->where('id', $id)
            ->with('pitches', 'user')->first();

        if (!$reservations) {
            return $this->errorResponse(__('error.reservationNotFound'), 422);
        }

        return $this->successResponse(new ReservationResource($reservations));
    }


    public function getTimeSlots(AvailableSlotRequest $request)
    {
        $schedule = $this->reservationService->getAvailableTimeSlots($request->validated());

        if ($schedule instanceof Schedule) {
            return $this->successResponse(new AvailableScheduleResource($schedule));
        }

        return $this->successResponse(__('error.scheduleNotAvailable'), 422);
    }

}
