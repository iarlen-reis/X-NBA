<?php

namespace Tests\Feature\Stats;

use App\Models\Stats;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_stats_endpoint(): void
    {
        Stats::factory(10)->create();

        $response = $this->getJson('/api/stats')
            ->assertStatus(200);

        $response->assertJsonCount(10);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->has(0, function ($json) {
                $json->whereType('id', 'string');
                $json->has('player', function ($json) {
                    $json->whereType('id', 'string');
                    $json->whereType('name', 'string');
                    $json->whereType('position', 'string');
                });
                $json->has('stats', function ($json) {
                    $json->whereType('min', 'integer');
                    $json->whereType('pts', 'integer');
                    $json->whereType('reb', 'integer');
                    $json->whereType('ast', 'integer');
                    $json->whereType('blk', 'integer');
                    $json->whereType('stl', 'integer');
                });
                $json->has('match', function ($json) {
                    $json->whereType('id', 'string');
                    $json->whereType('date', 'string');
                });
                $json->has('match_teams', function ($json) {
                    $json->has(0, function ($json) {
                        $json->whereType('id', 'string');
                        $json->whereType('role', 'string');
                        $json->whereType('score', 'integer');
                        $json->whereType('winner', 'boolean');
                        $json->has('team', function ($json) {
                            $json->whereType('id', 'string');
                            $json->whereType('name', 'string');
                            $json->whereType('slug', 'string');
                        });
                    });
                });
            });
        });
    }

    public function test_show_stats_endpoint(): void
    {
        $stats = Stats::factory()->create();

        $response = $this->getJson('/api/stats/' . $stats->id)
            ->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'player',
            'stats',
            'match',
            'match_teams',

        ]);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->whereType('id', 'string');
            $json->has('player', function ($json) {
                $json->whereType('id', 'string');
                $json->whereType('name', 'string');
                $json->whereType('position', 'string');
            });
            $json->has('stats', function ($json) {
                $json->whereType('min', 'integer');
                $json->whereType('pts', 'integer');
                $json->whereType('reb', 'integer');
                $json->whereType('ast', 'integer');
                $json->whereType('blk', 'integer');
                $json->whereType('stl', 'integer');
            });
            $json->has('match', function ($json) {
                $json->whereType('id', 'string');
                $json->whereType('date', 'string');
            });
            $json->has('match_teams', function ($json) {
                $json->has(0, function ($json) {
                    $json->whereType('id', 'string');
                    $json->whereType('role', 'string');
                    $json->whereType('score', 'integer');
                    $json->whereType('winner', 'boolean');
                    $json->has('team', function ($json) {
                        $json->whereType('id', 'string');
                        $json->whereType('name', 'string');
                        $json->whereType('slug', 'string');
                    });
                });
            });
        });
    }

    public function test_show_stats_endpoint_with_invalid_id(): void
    {
        $response = $this->getJson('/api/stats/9cac53be-803f-475e-98bc-8c73b48b2577')
            ->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Stats not found.');
        });
    }

    public function test_show_stats_endpoint_with_type_invalid_id(): void
    {
        $response = $this->getJson('/api/stats/12')
            ->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(['message' => 'Invalid ID provided, use a valid UUID.']);
    }

    public function test_store_stats_endpoint(): void
    {
        $stat = Stats::factory()->makeOne();

        $response = $this->postJson('/api/stats', [
            'min' => $stat->min,
            'pts' => $stat->pts,
            'reb' => $stat->reb,
            'ast' => $stat->ast,
            'blk' => $stat->blk,
            'stl' => $stat->stl,
            'player_id' => $stat->player_id,
            'match_team_id' => $stat->match_team_id
        ])->assertStatus(201);


        $response->assertJsonStructure([
            'id',
            'player',
            'stats',
            'match',
            'match_teams',

        ]);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->whereType('id', 'string');
            $json->has('player', function ($json) {
                $json->whereType('id', 'string');
                $json->whereType('name', 'string');
                $json->whereType('position', 'string');
            });
            $json->has('stats', function ($json) {
                $json->whereType('min', 'integer');
                $json->whereType('pts', 'integer');
                $json->whereType('reb', 'integer');
                $json->whereType('ast', 'integer');
                $json->whereType('blk', 'integer');
                $json->whereType('stl', 'integer');
            });
            $json->has('match', function ($json) {
                $json->whereType('id', 'string');
                $json->whereType('date', 'string');
            });
            $json->has('match_teams', function ($json) {
                $json->has(0, function ($json) {
                    $json->whereType('id', 'string');
                    $json->whereType('role', 'string');
                    $json->whereType('score', 'integer');
                    $json->whereType('winner', 'boolean');
                    $json->has('team', function ($json) {
                        $json->whereType('id', 'string');
                        $json->whereType('name', 'string');
                        $json->whereType('slug', 'string');
                    });
                });
            });
        });
    }

    public function test_update_stats_endpoint(): void
    {
        $stat = Stats::factory()->create();

        $response = $this->putJson('/api/stats/' . $stat->id, [
            'min' => 42,
            'pts' => 140,
            'reb' => 56,
            'ast' => 32,
            'blk' => 15,
            'stl' => 8,
            'player_id' => $stat->player_id,
            'match_team_id' => $stat->match_team_id
        ])->assertStatus(200);


        $response->assertJsonStructure([
            'id',
            'player',
            'stats',
            'match',
            'match_teams',

        ]);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->whereType('id', 'string');
            $json->has('player', function ($json) {
                $json->whereType('id', 'string');
                $json->whereType('name', 'string');
                $json->whereType('position', 'string');
            });
            $json->has('stats', function ($json) {
                $json->whereType('min', 'integer');
                $json->whereType('pts', 'integer');
                $json->whereType('reb', 'integer');
                $json->whereType('ast', 'integer');
                $json->whereType('blk', 'integer');
                $json->whereType('stl', 'integer');
            });
            $json->has('match', function ($json) {
                $json->whereType('id', 'string');
                $json->whereType('date', 'string');
            });
            $json->has('match_teams', function ($json) {
                $json->has(0, function ($json) {
                    $json->whereType('id', 'string');
                    $json->whereType('role', 'string');
                    $json->whereType('score', 'integer');
                    $json->whereType('winner', 'boolean');
                    $json->has('team', function ($json) {
                        $json->whereType('id', 'string');
                        $json->whereType('name', 'string');
                        $json->whereType('slug', 'string');
                    });
                });
            });
        });
    }

    public function test_update_stats_endpoint_with_invalid_id(): void
    {
        $stat = Stats::factory()->makeOne();

        $response = $this->putJson('/api/stats/9cac53be-803f-475e-98bc-8c73b48b2577', [
            'min' => 42,
            'pts' => 140,
            'reb' => 56,
            'ast' => 32,
            'blk' => 15,
            'stl' => 8,
            'player_id' => $stat->player_id,
            'match_team_id' => $stat->match_team_id
        ])->assertStatus(404);


        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson([
            'message' => 'Stats not found.',
        ]);
    }

    public function test_update_stats_endpoint_with_type_invalid_id(): void
    {
        $stat = Stats::factory()->makeOne();

        $response = $this->putJson('/api/stats/12', [
            'min' => 42,
            'pts' => 140,
            'reb' => 56,
            'ast' => 32,
            'blk' => 15,
            'stl' => 8,
            'player_id' => $stat->player_id,
            'match_team_id' => $stat->match_team_id
        ])->assertStatus(400);


        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(['message' => 'Invalid ID provided, use a valid UUID.']);
    }


    public function test_destroy_stats_endpoint(): void
    {
        $stat = Stats::factory()->create();

        $response = $this->deleteJson('/api/stats/' . $stat->id)
            ->assertStatus(204);

        $response->assertNoContent();

        $stats = Stats::find($stat->id);

        $this->assertNull($stats);
    }

    public function test_destroy_stats_endpoint_with_invalid_id(): void
    {
        $response = $this->deleteJson('/api/stats/9cac53be-803f-475e-98bc-8c73b48b2577')
            ->assertStatus(404);


        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson([
            'message' => 'Stats not found.',
        ]);
    }

    public function test_destroy_stats_endpoint_with_type_invalid_id(): void
    {
        $response = $this->deleteJson('/api/stats/12')
            ->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(['message' => 'Invalid ID provided, use a valid UUID.']);
    }
}
