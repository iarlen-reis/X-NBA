<?php

namespace Tests\Feature\Average;

use App\Models\Average;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AverageTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_average_endpoint(): void
    {
        Average::factory()->count(2)->create();

        $response = $this->getJson('/api/averages')->assertStatus(200);

        $response->assertJsonCount(2);

        $response->assertJson(function (AssertableJson $json) {
            $json->has(0, function ($json) {
                $json->has('player', function ($json) {
                    $json->whereType('id', 'string')
                        ->whereType('name', 'string')
                        ->whereType('position', 'string')
                        ->whereType('league', 'string');
                })->has('average', function ($json) {
                    $json->whereType('id', 'string')
                        ->whereType('pts', 'integer')
                        ->whereType('reb', 'integer')
                        ->whereType('ast', 'integer')
                        ->whereType('stl', 'integer')
                        ->whereType('blk', 'integer');
                });
            });
        });
    }

    public function test_show_average_endpoint(): void
    {
        $average = Average::factory()->create();

        $response = $this->getJson("/api/averages/{$average->id}")
            ->assertStatus(200);

        $response->assertJson([
            'player' => [
                'id' => $average->player->id,
                'name' => $average->player->name,
                'position' => $average->player->position,
                'league' => $average->player->league,
            ],
            'average' => [
                'id' => $average->id,
                'pts' => $average->pts,
                'reb' => $average->reb,
                'ast' => $average->ast,
                'stl' => $average->stl,
                'blk' => $average->blk,
            ],
        ]);
    }

    public function test_show_average_endpoint_with_invalid_id(): void
    {
        $response = $this->getJson('/api/averages/9cac53be-803f-475e-98bc-8c73b48b2577')
            ->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Average not found.');
        });
    }

    public function test_show_average_endpoint_with_type_invalid_id(): void
    {
        $response = $this->getJson('/api/averages/1')
            ->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Invalid ID provided, use a valid UUID.');
        });
    }

    public function test_store_average_endpoint(): void
    {
        $player = Player::factory()->create();

        $response = $this->postJson('/api/averages', [
            'pts' => 25,
            'reb' => 25,
            'ast' => 25,
            'stl' => 25,
            'blk' => 25,
            'player_id' => $player->id,
        ])->assertStatus(201);

        $average = Average::first();

        $response->assertJson([
            'player' => [
                'id' => $average->player->id,
                'name' => $average->player->name,
                'position' => $average->player->position,
                'league' => $average->player->league,
            ],
            'average' => [
                'id' => $average->id,
                'pts' => $average->pts,
                'reb' => $average->reb,
                'ast' => $average->ast,
                'stl' => $average->stl,
                'blk' => $average->blk,
            ],
        ]);
    }

    public function test_update_average_endpoint(): void
    {
        $average = Average::factory()->create();

        $response = $this->putJson("/api/averages/{$average->id}", [
            'pts' => 400,
            'reb' => 10,
            'ast' => 120,
            'stl' => 8,
            'blk' => 2,
            'player_id' => $average->player_id,
        ])->assertStatus(200);

        $response->assertJson([
            'player' => [
                'id' => $average->player->id,
                'name' => $average->player->name,
                'position' => $average->player->position,
                'league' => $average->player->league,
            ],
            'average' => [
                'id' => $average->id,
                'pts' => 400,
                'reb' => 10,
                'ast' => 120,
                'stl' => 8,
                'blk' => 2,
            ],
        ]);
    }

    public function test_update_average_endpoint_with_invalid_id(): void
    {
        $response = $this->putJson('/api/averages/9cac53be-803f-475e-98bc-8c73b48b2577', [
            'pts' => 400,
            'reb' => 10,
            'ast' => 120,
            'stl' => 8,
            'blk' => 2,
            'player_id' => '1',
        ])->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Average not found.');
        });
    }

    public function test_update_average_endpoint_with_type_invalid_id(): void
    {
        $response = $this->putJson('/api/averages/1', [
            'pts' => 400,
            'reb' => 10,
            'ast' => 120,
            'stl' => 8,
            'blk' => 2,
            'player_id' => '1',
        ])->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Invalid ID provided, use a valid UUID.');
        });
    }

    public function test_destroy_average_endpoint(): void
    {
        $average = Average::factory()->create();

        $this->deleteJson("/api/averages/{$average->id}")
            ->assertStatus(204);

        $findAverage = Average::find($average->id);

        $this->assertNull($findAverage);
    }

    public function test_destroy_average_endpoint_with_invalid_id(): void
    {
        $response = $this->deleteJson('/api/averages/9cac53be-803f-475e-98bc-8c73b48b2577')
            ->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Average not found.');
        });
    }

    public function test_destroy_average_endpoint_with_type_invalid_id(): void
    {
        $response = $this->deleteJson('/api/averages/1')
            ->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'Invalid ID provided, use a valid UUID.');
        });
    }
}
