<?php

namespace Tests\Feature\Team;

use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_index_teams_endpoint(): void
    {
        $teams = Team::factory(4)->create();

        $response = $this->getJson('/api/teams');

        $response->assertStatus(200);
        $response->assertJsonCount(4);

        $response->assertJson(function (AssertableJson $json) use ($teams) {
            $json->whereAllType([
                '0.id' => 'string',
                '0.name' => 'string',
                '0.slug' => 'string',
                '0.stadium' => 'string',
                '0.city' => 'string',
                '0.country' => 'string',
                '0.coach' => 'string',
                '0.league' => 'string',
                '0.created_at' => 'string',
                '0.updated_at' => 'string',
            ]);

            $team = $teams->first();

            $json->whereAll([
                '0.id' => $team->id,
                '0.name' => $team->name,
                '0.slug' => $team->slug,
                '0.stadium' => $team->stadium,
                '0.city' => $team->city,
                '0.country' => $team->country,
                '0.coach' => $team->coach,
                '0.league' => $team->league,
            ]);
        });
    }

    public function test_show_team_endpoint(): void
    {
        $team = Team::factory()->create();

        $response = $this->getJson("/api/teams/" . $team->id);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'name',
            'slug',
            'stadium',
            'city',
            'country',
            'coach',
            'league',
            'created_at',
            'updated_at',
        ]);

        $response->assertJson(function (AssertableJson $json) use ($team) {
            $json->hasAll([
                'id',
                'name',
                'slug',
                'stadium',
                'city',
                'country',
                'coach',
                'league',
                'created_at',
                'updated_at',
            ]);

            $json->whereAll([
                'id' => $team->id,
                'name' => $team->name,
                'slug' => $team->slug,
                'stadium' => $team->stadium,
                'city' => $team->city,
                'country' => $team->country,
                'coach' => $team->coach,
                'league' => $team->league,
            ]);
        });
    }

    public function test_show_team_endpoint_with_invalid_id(): void
    {
        $response = $this->getJson("/api/teams/9ca6a92f-1c98-42b8-bb0d-009e1b874228");

        $response->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Team not found.');
        });
    }

    public function test_show_team_endpoint_with_type_invalid_id(): void
    {
        $response = $this->getJson("/api/teams/9");

        $response->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Invalid ID provided, use a valid UUID.');
        });
    }
}
