<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'UA' => [
                ['name' => 'Kyiv', 'latitude' => 50.4501, 'longitude' => 30.5234],
                ['name' => 'Lviv', 'latitude' => 49.8397, 'longitude' => 24.0297],
                ['name' => 'Kharkiv', 'latitude' => 49.9935, 'longitude' => 36.2304],
            ],
            'US' => [
                ['name' => 'New York City', 'latitude' => 40.7128, 'longitude' => -74.0060],
                ['name' => 'Los Angeles', 'latitude' => 34.0522, 'longitude' => -118.2437],
                ['name' => 'Chicago', 'latitude' => 41.8781, 'longitude' => -87.6298],
            ],
            'DE' => [
                ['name' => 'Berlin', 'latitude' => 52.5200, 'longitude' => 13.4050],
                ['name' => 'Munich', 'latitude' => 48.1351, 'longitude' => 11.5820],
                ['name' => 'Hamburg', 'latitude' => 53.5511, 'longitude' => 9.9937],
            ],
        ];

        foreach ($cities as $iso => $citiesData) {
            $country = Country::where('iso_alpha_2', $iso)->first();

            foreach ($citiesData as $cityData) {
                City::firstOrCreate([
                    'country_id' => $country->id,
                    'name' => $cityData['name']
                ], $cityData);
            }
        }
    }
}
