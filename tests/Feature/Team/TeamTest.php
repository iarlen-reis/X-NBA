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
        $teams = Team::factory(4)->create(['active' => true]);

        $response = $this->getJson('/api/teams')->assertStatus(200);

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
                '0.active' => 'boolean',
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
                '0.active' => $team->active,
            ]);
        });
    }

    public function test_show_team_endpoint(): void
    {
        $team = Team::factory()->create(['active' => true]);

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
            'active',
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
                'active',
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
                'active' => $team->active,
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
            $json->each(function ($json) {
                $json->whereAllType([
                    'id' => 'string',
                    'name' => 'string',
                    'slug' => 'string',
                    'stadium' => 'string',
                    'city' => 'string',
                    'country' => 'string',
                    'coach' => 'string',
                    'league' => 'string',
                    'active' => 'boolean',
                    'created_at' => 'string',
                    'updated_at' => 'string',
                ]);
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
                'created_at',
                'updated_at',
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
            'active' => true,
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
                'active',
                'created_at',
                'updated_at',
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
