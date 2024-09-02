<?php

namespace Tests\Feature\Team;

use App\Models\Player;
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
        Team::factory(1)->create(['active' => true]);

        $response = $this->getJson('/api/teams')->assertStatus(200);

        $response->assertJsonCount(1);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->has(0, function ($json) {
                $json->whereType('id', 'string')
                    ->whereType('name', 'string')
                    ->whereType('slug', 'string')
                    ->whereType('stadium', 'string')
                    ->whereType('city', 'string')
                    ->whereType('country', 'string')
                    ->whereType('coach', 'string')
                    ->whereType('league', 'string');
            });
        });
    }

    public function test_show_team_endpoint(): void
    {
        $team = Team::factory()->create(['active' => true]);

        $player = Player::factory(2)->create(['team_id' => $team->id]);

        $response = $this->getJson("/api/teams/" . $team->id)
            ->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'name',
            'slug',
            'stadium',
            'city',
            'country',
            'coach',
            'league',
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
        $response = $this->getJson("/api/teams/9ca6a92f-1c98-42b8-bb0d-009e1b874228")
            ->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Team not found.');
        });
    }

    public function test_show_team_endpoint_with_type_invalid_id(): void
    {
        $response = $this->getJson("/api/teams/9")->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Invalid ID provided, use a valid UUID.');
        });
    }

    public function test_return_the_teams_from_the_league_filter(): void
    {
        $teamsWithLeagueNBA = Team::factory(10)->create(['league' => 'NBA']);
        $teamsWithLeagueWNBA = Team::factory(5)->create(['league' => 'WNBA']);

        $response = $this->getJson('/api/teams?league=nba')
            ->assertStatus(200);

        $response->assertJsonCount(10);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->has(0, function ($json) {
                $json->whereType('id', 'string')
                    ->whereType('name', 'string')
                    ->whereType('slug', 'string')
                    ->whereType('stadium', 'string')
                    ->whereType('city', 'string')
                    ->whereType('country', 'string')
                    ->whereType('coach', 'string')
                    ->whereType('league', 'string');
            });
        });

        $response->assertJsonFragment(['league' => 'NBA']);

        $response->assertJsonMissing(['league' => 'WNBA']);
    }

    public function test_store_team_endpoint(): void
    {
        $teamInstance = Team::factory(1)->makeOne(['active' => true]);

        $response = $this->postJson('/api/teams', [
            'name' => $teamInstance->name,
            'slug' => $teamInstance->slug,
            'stadium' => $teamInstance->stadium,
            'city' => $teamInstance->city,
            'country' => $teamInstance->country,
            'coach' => $teamInstance->coach,
            'league' => $teamInstance->league,
        ])->assertStatus(201);

        $team = Team::first();

        $response->assertJson([
            'id' => $team->id,
            'name' => $team->name,
            'slug' => $team->slug,
            'stadium' => $team->stadium,
            'city' => $team->city,
            'country' => $team->country,
            'coach' => $team->coach,
            'league' => $team->league,
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
            ]);
        });
    }

    public function test_update_team_endpoint(): void
    {
        $team = Team::factory()->create();

        $response = $this->putJson("/api/teams/" . $team->id, [
            'name' => 'New Team Name',
            'slug' => 'new-team-slug',
            'stadium' => 'New Stadium',
            'city' => 'New City',
            'country' => 'New Country',
            'coach' => 'New Coach',
            'league' => 'New League',
        ])->assertStatus(200);

        $response->assertJson([
            'id' => $team->id,
            'name' => 'New Team Name',
            'slug' => 'new-team-slug',
            'stadium' => 'New Stadium',
            'city' => 'New City',
            'country' => 'New Country',
            'coach' => 'New Coach',
            'league' => 'New League',
        ]);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->hasAll([
                'id',
                'name',
                'slug',
                'stadium',
                'city',
                'country',
                'coach',
                'league',
            ]);
        });
    }

    public function test_update_team_endpoint_with_invalid_id(): void
    {
        $response = $this->putJson("/api/teams/9ca6a92f-1c98-42b8-bb0d-009e1b874228", [
            'name' => 'New Team Name',
            'slug' => 'new-team-slug',
            'stadium' => 'New Stadium',
            'city' => 'New City',
            'country' => 'New Country',
            'coach' => 'New Coach',
            'league' => 'New League',
            'active' => true,
        ])->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Team not found.');
        });
    }

    public function test_update_team_endpoint_with_type_invalid_id(): void
    {
        $response = $this->putJson("/api/teams/9", [
            'name' => 'New Team Name',
            'slug' => 'new-team-slug',
            'stadium' => 'New Stadium',
            'city' => 'New City',
            'country' => 'New Country',
            'coach' => 'New Coach',
            'league' => 'New League',
            'active' => true,
        ])->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Invalid ID provided, use a valid UUID.');
        });
    }

    public function test_soft_delete_team_endpoint(): void
    {
        $team = Team::factory()->create();

        $this->deleteJson("/api/teams/" . $team->id)->assertStatus(204);

        $teams = Team::all()->where('active', true);

        $this->assertCount(0, $teams);
    }

    public function test_delete_team_endpoint_with_invalid_id(): void
    {
        $response = $this->deleteJson("/api/teams/9ca6a92f-1c98-42b8-bb0d-009e1b874228")
            ->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Team not found.');
        });
    }

    public function test_delete_team_endpoint_with_type_invalid_id(): void
    {
        $response = $this->deleteJson("/api/teams/9")
            ->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Invalid ID provided, use a valid UUID.');
        });
    }

    public function test_restore_team_endpoint(): void
    {
        $team = Team::factory()->create(['active' => false]);

        $activeTeams = Team::all()->where('active', false);

        $this->assertCount(1, $activeTeams);

        $this->deleteJson("/api/teams/" . $team->id)
            ->assertStatus(204);

        $teams = Team::all()->where('active', true);

        $this->assertCount(1, $teams);
    }
}
