<?php

namespace Database\Factories;

use App\Models\Matche;
use App\Models\MatchTeam;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MatchTeam>
 */
class MatchTeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'match_id' => Matche::factory(),
            'team_id' => Team::factory(),
            'role' => fake()->randomElement(['home', 'away']),
            'score' => fake()->numberBetween(0, 100),
            'winner' => fake()->boolean(),
        ];
    }
}
