<?php

namespace Database\Seeders;

use App\Models\Stadium;
use Illuminate\Database\Seeder;

class StadiumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define stadium data
        $stadiumsData = [
            ['name' => 'Stadium 1', 'location' => 'Location 1'],
            ['name' => 'Stadium 2', 'location' => 'Location 2'],
        ];

        // Insert stadium records and get their IDs
        Stadium::insert($stadiumsData);

        // Retrieve stadiums to assign pitches
        $stadiums    = Stadium::get();
        $pitchesData = [
            ['name' => 'Pitch 1', 'price' => 100],
            ['name' => 'Pitch 2', 'price' => 50],
            ['name' => 'Pitch 3', 'price' => 75],
        ];
        // Assign pitches to each stadium
        foreach ($stadiums as $stadium) {
            foreach ($pitchesData as $pitch) {
                $stadium->pitches()->create($pitch);
            }
        }
    }
}
