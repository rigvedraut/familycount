<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\City;

class StateCitySeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            'Maharashtra' => ['Mumbai', 'Pune', 'Nagpur'],
            'Gujarat' => ['Ahmedabad', 'Surat', 'Vadodara'],
            'Karnataka' => ['Bengaluru', 'Mysuru'],
            'Delhi' => ['New Delhi'],
            'Rajasthan' => ['Jaipur', 'Jodhpur'],
        ];

        foreach ($locations as $stateName => $cityNames) {
            $state = State::firstOrCreate([
                'name' => $stateName,
            ]);

            foreach ($cityNames as $cityName) {
                City::firstOrCreate([
                    'state_id' => $state->id,
                    'name' => $cityName,
                ]);
            }
        }
    }
}