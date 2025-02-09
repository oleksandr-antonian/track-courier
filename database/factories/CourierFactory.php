<?php

namespace Database\Factories;

use App\Enums\CourierAvailabilityStatus;
use App\Enums\CourierTransportType;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->e164PhoneNumber(),
            'availability_status' => $this->faker->randomElement(CourierAvailabilityStatus::getValues()),
            'transport_type' => $this->faker->randomElement(CourierTransportType::getValues()),
            'city_id' => City::inRandomOrder()->first()?->id ?? City::factory(),
        ];
    }
}
