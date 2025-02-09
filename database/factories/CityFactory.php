<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'country_id' => Country::inRandomOrder()->first()?->id ?? Country::factory(),
            'name' => $this->faker->city(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
        ];
    }
}
