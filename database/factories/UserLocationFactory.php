<?php

namespace Database\Factories;

use App\Models\UserLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserLocation>
 */
class UserLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => null,
            'user_id' => null,
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
        ];
    }
}
