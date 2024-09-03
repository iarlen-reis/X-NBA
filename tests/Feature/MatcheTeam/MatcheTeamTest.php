<?php

namespace Tests\Feature\MatcheTeam;

use App\Models\MatchTeam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class MatcheTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_matche_team_endpoint()
    {
        MatchTeam::factory()->count(3)->create();

        $response = $this->getJson('/api/matche-teams');

        $response->assertStatus(200);
        $response->assertJsonCount(3);

        $response->assertJson(function (AssertableJson $json) {
            $json->has(0, function ($json) {
                $json->whereType('id', 'string');
                $json->whereType('role', 'string');
                $json->whereType('score', 'integer');
                $json->whereType('winner', 'boolean');
                $json->has('match', function ($json) {
                    $json->whereType('id', 'string');
                    $json->whereType('date', 'string');
                    $json->whereType('location', 'string');
                    $json->whereType('stadium', 'string');
                    $json->whereType('league', 'string');
                });
                $json->has('team', function ($json) {
                    $json->whereType('id', 'string');
                    $json->whereType('name', 'string');
                    $json->whereType('slug', 'string');
                });
            });
        });
    }

    public function test_show_matche_team_endpoint()
    {
        $matchTeam = MatchTeam::factory()->create();

        $response = $this->getJson("/api/matche-teams/" . $matchTeam->id)
            ->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'role',
            'score',
            'winner',
            'match',
            'team',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->whereType('id', 'string');
            $json->whereType('role', 'string');
            $json->whereType('score', 'integer');
            $json->whereType('winner', 'boolean');
            $json->has('match', function ($json) {
                $json->whereType('id', 'string');
                $json->whereType('date', 'string');
                $json->whereType('location', 'string');
                $json->whereType('stadium', 'string');
                $json->whereType('league', 'string');
            });
            $json->has('team', function ($json) {
                $json->whereType('id', 'string');
                $json->whereType('name', 'string');
                $json->whereType('slug', 'string');
            });
        });
    }

    public function test_show_matche_team_endpoint_with_invalid_id()
    {
        $response = $this->getJson('/api/matche-teams/9cac53be-803f-475e-98bc-8c73b48b2577')
            ->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Match team not found.');
        });
    }

    public function test_show_matche_team_endpoint_with_type_invalid_id()
    {
        $response = $this->getJson('/api/matche-teams/1')
            ->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Invalid ID provided, use a valid UUID.');
        });
    }

    public function test_store_matche_team_endpoint()
    {
        $matchTeam = MatchTeam::factory()->makeOne();

        $response = $this->postJson('/api/matche-teams', [
            'match_id' => $matchTeam->match_id,
            'team_id' => $matchTeam->team_id,
            'role' => $matchTeam->role,
            'score' => $matchTeam->score,
            'winner' => $matchTeam->winner,
        ])->assertStatus(201);


        $response->assertJson(function (AssertableJson $json) use ($matchTeam) {
            $json->whereType('id', 'string');
            $json->whereType('role', 'string');
            $json->whereType('score', 'integer');
            $json->whereType('winner', 'boolean');
            $json->has('match', function ($json) use ($matchTeam) {
                $json->whereType('id', 'string');
                $json->whereType('date', 'string');
                $json->whereType('location', 'string');
                $json->whereType('stadium', 'string');
                $json->whereType('league', 'string');
            });
            $json->has('team', function ($json) use ($matchTeam) {
                $json->whereType('id', 'string');
                $json->whereType('name', 'string');
                $json->whereType('slug', 'string');
            });
        });
    }

    public function test_update_matche_team_endpoint()
    {
        $matchTeam = MatchTeam::factory()->create([
            'role' => 'away',
        ]);

        $response = $this->putJson("/api/matche-teams/{$matchTeam->id}", [
            'match_id' => $matchTeam->match_id,
            'team_id' => $matchTeam->team_id,
            'role' => 'home',
            'score' => $matchTeam->score,
            'winner' => $matchTeam->winner,
        ])->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'role',
            'score',
            'winner',
            'match',
            'team',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->whereType('id', 'string');
            $json->whereType('role', 'string');
            $json->whereType('score', 'integer');
            $json->whereType('winner', 'boolean');
            $json->has('match', function ($json) {
                $json->whereType('id', 'string');
                $json->whereType('date', 'string');
                $json->whereType('location', 'string');
                $json->whereType('stadium', 'string');
                $json->whereType('league', 'string');
            });
            $json->has('team', function ($json) {
                $json->whereType('id', 'string');
                $json->whereType('name', 'string');
                $json->whereType('slug', 'string');
            });
        });

        $response->assertJson([
            'id' => $matchTeam->id,
            'role' => 'home',
            'score' => $matchTeam->score,
            'winner' => $matchTeam->winner,
            'match' => [
                'id' => $matchTeam->match_id,
                'date' => $matchTeam->match->date,
                'location' => $matchTeam->match->location,
                'stadium' => $matchTeam->match->stadium,
                'league' => $matchTeam->match->league,
            ],
            'team' => [
                'id' => $matchTeam->team_id,
                'name' => $matchTeam->team->name,
                'slug' => $matchTeam->team->slug,
            ],
        ]);
    }

    public function test_update_matche_team_endpoint_with_invalid_id()
    {
        $response = $this->putJson('/api/matche-teams/9cac53be-803f-475e-98bc-8c73b48b2577', [
            'match_id' => '9cac53be-803f-475e-98bc-8c73b48b2577',
            'team_id' => '9cac53be-803f-475e-98bc-8c73b48b2577',
            'role' => 'home',
            'score' => 0,
            'winner' => false,
        ])->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Match team not found.');
        });
    }

    public function test_update_matche_team_endpoint_with_type_invalid_id()
    {
        $response = $this->putJson('/api/matche-teams/1', [
            'match_id' => '9cac53be-803f-475e-98bc-8c73b48b2577',
            'team_id' => '9cac53be-803f-475e-98bc-8c73b48b2577',
            'role' => 'home',
            'score' => 0,
            'winner' => false,
        ])->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Invalid ID provided, use a valid UUID.');
        });
    }

    public function test_delete_matche_team_endpoint()
    {
        $matchTeam = MatchTeam::factory()->create();

        $this->deleteJson("/api/matche-teams/{$matchTeam->id}")
            ->assertStatus(204);

        $findMatchTeam = MatchTeam::find($matchTeam->id);

        $this->assertNull($findMatchTeam);
    }

    public function test_delete_matche_team_endpoint_with_invalid_id()
    {
        $response = $this->deleteJson('/api/matche-teams/9cac53be-803f-475e-98bc-8c73b48b2577')
            ->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Match team not found.');
        });
    }

    public function test_delete_matche_team_endpoint_with_type_invalid_id()
    {
        $response = $this->deleteJson('/api/matche-teams/1')
            ->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Invalid ID provided, use a valid UUID.');
        });
    }
}
