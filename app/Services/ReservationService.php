<?php

namespace App\Services;

use App\Models\Pitch;
use App\Models\Slot;
use Carbon\Carbon;

class ReservationService
{
    public function checkAvailableSlots($schedule, $date): int
    {

        // Retrieve buffer slots on the specified date
        $buffer_slots = Slot::whereHas('schedule', function ($q) use ($date) {
            $q->where('date', $date);
        })->get();

        // Get all slots for this instance
        $slots = $schedule->slots;

        // Filter slots that do not overlap with any buffer slots
        $available_slots = $slots->filter(function ($slot) use ($buffer_slots) {

            foreach ($buffer_slots as $buffer_slot) {

// Check if the slot falls within the buffer slot time range
                if ($slot->from < $buffer_slot->to && $slot->to > $buffer_slot->from) {
                    return false; // Exclude slot overlapping with buffer slot
                }

            }

            return true; // Include slot if no overlap
        });

        // Divide each slot into 1-hour blocks
        $hourly_slots = collect();

// Use collection for filtering

        foreach ($available_slots as $slot) {
            $start_time = Carbon::parse($slot->from);
            $end_time   = Carbon::parse($slot->to);

// Loop from the start time to the end time in 1-hour increments
            while ($start_time->lt($end_time)) {
                $next_hour = $start_time->copy()->addHour();
                if ($next_hour->gt($end_time)) {
                    $next_hour = $end_time; // Ensure last block doesn't exceed slot's end time
                }

                // Add the 1-hour block to the collection
                $hourly_slots->push([
                    'id'          => $slot->id,
                    'from'        => $start_time->format('H:i'),
                    'to'          => $next_hour->format('H:i'),
                    'from_format' => $start_time->format('h:i A'),
                    'to_format'   => $next_hour->format('h:i A')
                ]);

                // Move to the next hour
                $start_time = $next_hour;
            }

        }

        // Get reservations for the specified date
        $reservations = $schedule->reservations()->whereHas('status', function ($q) {
            $q->whereIn('key', ['new', 'completed']);
        })->whereDate('reservation_date', $date)->get();

        // Filter hourly slots based on reservations
        $filtered_slots = $hourly_slots->filter(function ($slot) use ($reservations) {

            foreach ($reservations as $reservation) {
                $reservation_time = Carbon::parse($reservation->reservation_date)->format('H:i');

// Check if the slot overlaps with any reservation time
                if ($slot['from'] <= $reservation_time && $slot['to'] >= $reservation_time) {
                    return false; // Exclude slot overlapping with reservation
                }

            }

            return true; // Include slot if no overlap
        });

        if (Carbon::parse($date)->isToday()) {
            $current_time   = Carbon::now()->setTimezone('Asia/Riyadh')->format('H:i');
            $filtered_slots = $filtered_slots->filter(function ($slot) use ($current_time) {
                // Exclude slots that end before the current time
                return $slot['to'] > $current_time;
            });
        }

        // Return the filtered slots as an array
        return $filtered_slots->count();
    }

    public function getAvailableSlots($schedule)
    {
        // Get the requested date from the request
        $date = request()->date;

        // Retrieve buffer slots on the specified date
        $buffer_slots = Slot::whereHas('schedule', function ($q) use ($date) {
            $q->where('date', $date);
        })->get();

        // Get all slots for this instance
        $slots = $schedule->slots;

        // Filter slots that do not overlap with any buffer slots
        $available_slots = $slots->filter(function ($slot) use ($buffer_slots) {

            foreach ($buffer_slots as $buffer_slot) {

// Check if the slot falls within the buffer slot time range
                if ($slot->from < $buffer_slot->to && $slot->to > $buffer_slot->from) {
                    return false; // Exclude slot overlapping with buffer slot
                }

            }

            return true; // Include slot if no overlap
        });

        // Divide each slot into 1-hour blocks
        $hourly_slots = collect();

// Use collection for filtering

        foreach ($available_slots as $slot) {
            $start_time = Carbon::parse($slot->from);
            $end_time   = Carbon::parse($slot->to);

// Loop from the start time to the end time in 1-hour increments
            while ($start_time->lt($end_time)) {
                $next_hour = $start_time->copy()->addHour();
                if ($next_hour->gt($end_time)) {
                    $next_hour = $end_time; // Ensure last block doesn't exceed slot's end time
                }

                // Add the 1-hour block to the collection
                $hourly_slots->push([
                    'id'          => $slot->id,
                    'from'        => $start_time->format('H:i'),
                    'to'          => $next_hour->format('H:i'),
                    'from_format' => $start_time->format('h:i A'),
                    'to_format'   => $next_hour->format('h:i A')
                ]);

                // Move to the next hour
                $start_time = $next_hour;
            }

        }

        // Get reservations for the specified date
        $reservations = $schedule->reservations()->whereHas('status', function ($q) {
            $q->whereIn('key', ['new', 'completed']);
        })->whereDate('reservation_date', $date)->get();

        // Filter hourly slots based on reservations
        $filtered_slots = $hourly_slots->filter(function ($slot) use ($reservations) {

            foreach ($reservations as $reservation) {
                $reservation_time = Carbon::parse($reservation->reservation_date)->format('H:i');

// Check if the slot overlaps with any reservation time
                if ($slot['from'] <= $reservation_time && $slot['to'] >= $reservation_time) {
                    return false; // Exclude slot overlapping with reservation
                }

            }

            return true; // Include slot if no overlap
        });

        if (Carbon::parse($date)->isToday()) {
            $current_time   = Carbon::now()->setTimezone('Asia/Riyadh')->format('H:i');
            $filtered_slots = $filtered_slots->filter(function ($slot) use ($current_time) {
                // Exclude slots that end before the current time
                return $slot['to'] > $current_time;
            });
        }

        // Return the filtered slots as an array
        return $filtered_slots->toArray();
    }

    public function getAvailableTimeSlots(array $data)
    {
        $pitch    = Pitch::findOrFail($data['pitch_id']);
        $date     = Carbon::parse($data['date'])->locale('en');
        $schedule = $pitch->schedules()
            ->where('day', $date->translatedFormat('l'))
            ->whereHas('slots')
            ->where('date', null)
            ->with('slots')
            ->first();

        if (!$schedule || !$schedule->is_active) {
            return false;
        }

        return $schedule;
    }
}
