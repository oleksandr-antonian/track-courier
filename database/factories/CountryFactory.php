<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->country(),
            'iso_alpha_2' => $this->faker->unique()->countryCode(),
            'iso_alpha_3' => $this->faker->unique()->countryISOAlpha3(),
            'iso_numeric' => $this->faker->unique()->randomNumber(3, true),
        ];
    }
}
