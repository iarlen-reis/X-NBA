<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->streetName(),
            'slug' => $this->faker->slug(),
            'stadium' => $this->faker->word(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'coach' => $this->faker->name(),
            'league' => $this->faker->randomElement(['NBA', 'WNBA']),
            'active' => $this->faker->boolean(chanceOfGettingTrue: 100),
        ];
    }
}
