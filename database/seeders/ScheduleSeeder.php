<?php

namespace Database\Seeders;

use App\Models\Pitch;
use App\Models\Stadium;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [
            'Saturday',
            'Wednesday',
            'Friday',
        ];
        // slots
        $slots   = [
            ['from' => '08:00', 'to' => '09:00'],
            ['from' => '09:00', 'to' => '10:30'],
            ['from' => '10:30', 'to' => '12:00'],
            ['from' => '12:00', 'to' => '13:00'],
            ['from' => '13:00', 'to' => '14:30'],
            ['from' => '14:30', 'to' => '15:30'],
        ];
        $pitches = Pitch::get();
        foreach ($pitches as $pitch) {
            foreach ($days as $day) {
                $schedule = $pitch->schedules()->create([
                    'day' => $day,
                ]);
                $schedule->slots()->createMany($slots);
            }
        }
    }
}
