<?php

namespace Tests\Feature\Player;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_players_endpoint(): void
    {
        Team::factory()->create([
            'name' => 'New York Knicks',
        ]);

        Player::factory(2)->withAverage()->create();

        $response = $this->getJson('/api/players')->assertStatus(200);

        $response->assertJsonCount(2);

        $response->assertJson(function (AssertableJson $json) {
            $json->has(0, function ($json) {
                $json->whereType('id', 'string')
                    ->whereType('name', 'string')
                    ->whereType('age', 'integer')
                    ->whereType('height', 'integer')
                    ->whereType('weight', 'integer')
                    ->whereType('position', 'string')
                    ->whereType('league', 'string')
                    ->whereType('team_id', 'string')
                    ->whereType('active', 'boolean')
                    ->whereType('average', 'array')
                    ->whereType('created_at', 'string')
                    ->whereType('updated_at', 'string')
                    ->has('average', function ($json) {
                        $json->whereType('id', 'string')
                            ->whereType('pts', 'integer')
                            ->whereType('reb', 'integer')
                            ->whereType('ast', 'integer')
                            ->whereType('stl', 'integer')
                            ->whereType('blk', 'integer')
                            ->whereType('player_id', 'string')
                            ->whereType('created_at', 'string')
                            ->whereType('updated_at', 'string');
                    });
            });
        });
    }

    public function test_show_player_endpoint(): void
    {
        $player = Player::factory()->withAverage()->create()->load('team');

        $response = $this->getJson("/api/players/{$player->id}")
            ->assertStatus(200);

        $response->assertJson([
            'id' => $player->id,
            'name' => $player->name,
            'age' => $player->age,
            'height' => $player->height,
            'weight' => $player->weight,
            'position' => $player->position,
            'league' => $player->league,
            'team_id' => $player->team_id,
            'active' => $player->active,
            'team' => $player->team->toArray(),
            'average' => $player->average->toArray(),
        ]);
    }

    public function test_show_player_endpoint_with_invalid_id(): void
    {
        $response = $this->getJson('/api/players/9cac53be-803f-475e-98bc-8c73b48b2577')
            ->assertStatus(404);

        $response->assertJson(['message' => 'Player not found.']);
    }

    public function test_show_player_endpoint_with_type_invalid_id(): void
    {
        $response = $this->getJson('/api/players/1')
            ->assertStatus(400);

        $response->assertJson(['message' => 'Invalid ID provided, use a valid UUID.']);
    }

    public function test_store_player_endpoint(): void
    {
        $playerInstance = Player::factory(1)->makeOne([
            'name' => 'Michael Jordan'
        ]);

        $response = $this->postJson('/api/players', [
            'name' => $playerInstance->name,
            'age' => $playerInstance->age,
            'height' => $playerInstance->height,
            'weight' => $playerInstance->weight,
            'position' => $playerInstance->position,
            'team_id' => $playerInstance->team_id,
            'league' => $playerInstance->league,
        ])->assertStatus(201);

        $player = Player::first();

        $response->assertJson([
            'id' => $player->id,
            'name' => $player->name,
            'age' => $player->age,
            'height' => $player->height,
            'weight' => $player->weight,
            'position' => $player->position,
            'team_id' => $player->team_id,
            'league' => $player->league,
        ]);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->hasAll([
                'id',
                'name',
                'age',
                'height',
                'weight',
                'position',
                'team_id',
                'league',
                'created_at',
                'updated_at'
            ]);
        });
    }

    public function test_update_player_endpoint(): void
    {
        $player = Player::factory()->create();

        $response = $this->putJson("/api/players/{$player->id}", [
            'name' => 'Michael Jordan',
            'age' => 30,
            'height' => 180,
            'weight' => 80,
            'position' => 'Center',
            'team_id' => $player->team_id,
            'league' => $player->league,
        ])->assertStatus(200);

        $response->assertJson([
            'id' => $player->id,
            'name' => 'Michael Jordan',
            'age' => 30,
            'height' => 180,
            'weight' => 80,
            'position' => 'Center',
            'team_id' => $player->team_id,
            'league' => $player->league,
            'active' => $player->active,
        ]);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->hasAll([
                'id',
                'name',
                'age',
                'height',
                'weight',
                'position',
                'team_id',
                'league',
                'active',
                'created_at',
                'updated_at'
            ]);
        });
    }

    public function test_update_player_endpoint_with_invalid_id(): void
    {
        $response = $this->putJson('/api/players/9cac53be-803f-475e-98bc-8c73b48b2577', [
            'name' => 'Michael Jordan',
            'age' => 30,
            'height' => 180,
            'weight' => 80,
            'position' => 'Center',
            'team_id' => '1',
            'league' => 'NBA',
        ])->assertStatus(404);

        $response->assertJson(['message' => 'Player not found.']);
    }

    public function test_update_player_endpoint_with_type_invalid_id(): void
    {
        $response = $this->putJson('/api/players/1', [
            'name' => 'Michael Jordan',
            'age' => 30,
            'height' => 180,
            'weight' => 80,
            'position' => 'Center',
            'team_id' => '1',
            'league' => 'NBA',
        ])->assertStatus(400);

        $response->assertJson(['message' => 'Invalid ID provided, use a valid UUID.']);
    }

    public function test_soft_delete_player_endpoint(): void
    {
        $player = Player::factory()->create();

        $this->deleteJson("/api/players/" . $player->id)->assertStatus(204);

        $players = Player::all()->where('active', true);

        $this->assertCount(0, $players);
    }

    public function test_restore_player_endpoint(): void
    {
        $player = Player::factory()->create(['active' => false]);

        $activePlayers = Player::all()->where('active', true);

        $this->assertCount(0, $activePlayers);

        $this->deleteJson("/api/players/" . $player->id)
            ->assertStatus(204);

        $players = Player::all()->where('active', true);

        $this->assertCount(1, $players);
    }
}
