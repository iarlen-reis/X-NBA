<?php

namespace Database\Factories;

use App\Models\MatchTeam;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stats>
 */
class StatsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'min' => $this->faker->numberBetween(2, 32),
            'pts' => $this->faker->numberBetween(0, 100),
            'reb' => $this->faker->numberBetween(0, 100),
            'ast' => $this->faker->numberBetween(0, 100),
            'blk' => $this->faker->numberBetween(0, 100),
            'stl' => $this->faker->numberBetween(0, 100),
            'player_id' => Player::factory(),
            'match_team_id' => MatchTeam::factory(),
        ];
    }
}
