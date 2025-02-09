<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Ukraine',
                'iso_alpha_2' => 'UA',
                'iso_alpha_3' => 'UKR',
                'iso_numeric' => 804
            ],
            [
                'name' => 'United States',
                'iso_alpha_2' => 'US',
                'iso_alpha_3' => 'USA',
                'iso_numeric' => 840
            ],
            [
                'name' => 'Germany',
                'iso_alpha_2' => 'DE',
                'iso_alpha_3' => 'DEU',
                'iso_numeric' => 276
            ],
        ];

        foreach ($countries as $countryData) {
            Country::firstOrCreate([
                'iso_alpha_2' => $countryData['iso_alpha_2']
            ], $countryData);
        }
    }
}
