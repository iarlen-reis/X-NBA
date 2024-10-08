<?php

namespace Tests\Feature\Matche;

use App\Models\Matche;
use App\Models\MatchTeam;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Assert;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class MatcheTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_matche_endpoint(): void
    {

        $match = Matche::factory()->create();

        $team = Team::factory()->create();
        $team2 = Team::factory()->create();

        MatchTeam::factory()->create([
            'match_id' => $match->id,
            'team_id' => $team->id,
            'role' => 'home',
            'score' => 100,
            'winner' => true,
        ]);

        MatchTeam::factory()->create([
            'match_id' => $match->id,
            'team_id' => $team2->id,
            'role' => 'away',
            'score' => 98,
            'winner' => false,
        ]);

        $response = $this->getJson('/api/matches')->assertStatus(200);

        $response->assertJsonCount(1);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->has(0, function (AssertableJson $json) {
                $json->whereType('id', 'string');
                $json->whereType('date', 'string');
                $json->whereType('location', 'string');
                $json->whereType('stadium', 'string');
                $json->whereType('league', 'string')
                    ->has('matches_teams', 2, function (AssertableJson $json) {
                        $json->whereType('id', 'string');
                        $json->whereType('role', 'string');
                        $json->whereType('team', 'array');
                        $json->whereType('score', 'integer');
                        $json->whereType('winner', 'boolean');
                        $json->has('team', function (AssertableJson $json) {
                            $json->whereType('id', 'string');
                            $json->whereType('name', 'string');
                            $json->whereType('slug', 'string');
                        });
                    });
            });
        });
    }

    public function test_index_matche_endpoint_with_slug(): void
    {
        $team = Team::factory()->create([
            'name' => 'Miami Heat',
            'slug' => 'miami-heat',
        ]);

        $match = Matche::factory()->create();
        $match2 = Matche::factory()->create();
        Matche::factory(8)->create();

        MatchTeam::factory()->create([
            'match_id' => $match->id,
            'team_id' => $team->id,
            'role' => 'home',
            'score' => 100,
            'winner' => true,
        ]);

        MatchTeam::factory()->create([
            'match_id' => $match2->id,
            'team_id' => $team->id,
            'role' => 'home',
            'score' => 98,
            'winner' => false,
        ]);

        $response = $this->getJson('/api/matches?slug=miami-heat')
            ->assertStatus(200);

        $response->assertJsonCount(2);
    }

    public function test_show_matche_endpoint(): void
    {
        $match = Matche::factory()->create();

        $team = Team::factory()->create();
        $team2 = Team::factory()->create();

        MatchTeam::factory()->create([
            'match_id' => $match->id,
            'team_id' => $team->id,
            'role' => 'home',
        ]);

        MatchTeam::factory()->create([
            'match_id' => $match->id,
            'team_id' => $team2->id,
            'role' => 'away',
        ]);

        $response = $this->getJson("/api/matches/{$match->id}")
            ->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->whereType('id', 'string')
                ->whereType('date', 'string')
                ->whereType('location', 'string')
                ->whereType('stadium', 'string')
                ->whereType('league', 'string')
                ->has('matches_teams', 2, function (AssertableJson $json) {
                    $json->whereType('id', 'string');
                    $json->whereType('role', 'string');
                    $json->whereType('score', 'integer');
                    $json->whereType('winner', 'boolean');
                    $json->whereType('team', 'array');
                    $json->has('team', function (AssertableJson $json) {
                        $json->whereType('id', 'string');
                        $json->whereType('name', 'string');
                        $json->whereType('slug', 'string');
                    });
                });
        });
    }

    public function test_show_matche_endpoint_with_invalid_id(): void
    {
        $response = $this->getJson('/api/matches/9cac53be-803f-475e-98bc-8c73b48b2577')
            ->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Match not found.');
        });
    }

    public function test_show_matche_endpoint_with_type_invalid_id(): void
    {
        $response = $this->getJson('/api/matches/1')
            ->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Invalid ID provided, use a valid UUID.');
        });
    }

    public function test_store_matche_endpoint(): void
    {
        $matche = Matche::factory()->makeOne();

        $response = $this->postJson('/api/matches', [
            'date' => $matche->date,
            'location' => $matche->location,
            'stadium' => $matche->stadium,
            'league' => $matche->league,
        ])->assertStatus(201);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->whereType('id', 'string')
                ->whereType('date', 'string')
                ->whereType('location', 'string')
                ->whereType('stadium', 'string')
                ->whereType('league', 'string')
                ->whereType('matches_teams', 'array');
        });

        $matche = Matche::first();

        $response->assertJson([
            'id' => $matche->id,
            'date' => $matche->date,
            'location' => $matche->location,
            'stadium' => $matche->stadium,
            'league' => $matche->league,
            'matches_teams' => [],
        ]);
    }

    public function test_update_matche_endpoint(): void
    {
        $matche = Matche::factory()->create();

        $response = $this->putJson("/api/matches/{$matche->id}", [
            'date' => '2024-08-06',
            'location' => 'New York',
            'stadium' => 'Madison Square Garden',
            'league' => 'NBA',
        ])->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->whereType('id', 'string')
                ->whereType('date', 'string')
                ->whereType('location', 'string')
                ->whereType('stadium', 'string')
                ->whereType('league', 'string')
                ->whereType('matches_teams', 'array');
        });

        $response->assertJson([
            'id' => $matche->id,
            'date' => '2024-08-06',
            'location' => 'New York',
            'stadium' => 'Madison Square Garden',
            'league' => 'NBA',
            'matches_teams' => [],
        ]);
    }

    public function test_update_matche_endpoint_with_invalid_id(): void
    {
        $response = $this->putJson('/api/matches/9cac53be-803f-475e-98bc-8c73b48b2577', [
            'date' => '2024-08-06',
            'location' => 'New York',
            'stadium' => 'Madison Square Garden',
            'league' => 'NBA',
        ])->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Match not found.');
        });
    }

    public function test_update_matche_endpoint_with_type_invalid_id(): void
    {
        $response = $this->putJson('/api/matches/1', [
            'date' => '2024-08-06',
            'location' => 'New York',
            'stadium' => 'Madison Square Garden',
            'league' => 'NBA',
        ])->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Invalid ID provided, use a valid UUID.');
        });
    }

    public function test_destroy_matche_endpoint(): void
    {
        $matche = Matche::factory()->create();

        $this->deleteJson("/api/matches/{$matche->id}")
            ->assertStatus(204);

        $findMatch = Matche::find($matche->id);

        $this->assertNull($findMatch);
    }

    public function test_destroy_matche_endpoint_with_invalid_id(): void
    {
        $response = $this->deleteJson('/api/matches/9cac53be-803f-475e-98bc-8c73b48b2577')
            ->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Match not found.');
        });
    }

    public function test_destroy_matche_endpoint_with_type_invalid_id(): void
    {
        $response = $this->deleteJson('/api/matches/1')
            ->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Invalid ID provided, use a valid UUID.');
        });
    }
}
