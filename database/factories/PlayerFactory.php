<?php

namespace Database\Factories;

use App\Models\Average;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(18, 40),
            'height' => $this->faker->numberBetween(60, 200),
            'weight' => $this->faker->numberBetween(200, 800),
            'position' => $this->faker->randomElement(['F', 'C', 'G', 'PG', 'SG']),
            'league' => $this->faker->randomElement(['NBA', 'WNBA']),
            'active' => $this->faker->boolean(chanceOfGettingTrue: 100),
            'team_id' => Team::factory(),
        ];
    }

    public function withAverage()
    {
        return $this->has(Average::factory(), 'average');
    }
}
