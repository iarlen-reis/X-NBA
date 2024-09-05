<?php

namespace Tests\Feature\Player;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
                    ->whereType('average', 'array')
                    ->has('average', function ($json) {
                        $json->whereType('min', 'string')
                            ->whereType('pts', 'string')
                            ->whereType('reb', 'string')
                            ->whereType('ast', 'string')
                            ->whereType('stl', 'string')
                            ->whereType('blk', 'string');
                    })
                    ->has('team', function ($json) {
                        $json->whereType('id', 'string')
                            ->whereType('name', 'string')
                            ->whereType('slug', 'string');
                    });
            });
        });
    }

    public function test_index_players_endpoint_with_team_filter(): void
    {
        $team = Team::factory()->create([
            'name' => 'New York Knicks',
            'slug' => 'new-york-knicks',
        ]);

        Player::factory(2)->withAverage()->create([
            'team_id' => $team->id,
        ]);

        Player::factory(10)->withAverage()->create();

        $response = $this->getJson('/api/players?team=new-york-knicks')
            ->assertStatus(200);

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
                    ->whereType('average', 'array')
                    ->has('average', function ($json) {
                        $json->whereType('min', 'string')
                            ->whereType('pts', 'string')
                            ->whereType('reb', 'string')
                            ->whereType('ast', 'string')
                            ->whereType('stl', 'string')
                            ->whereType('blk', 'string');
                    })
                    ->has('team', function ($json) {
                        $json->whereType('id', 'string')
                            ->whereType('name', 'string')
                            ->whereType('slug', 'string');
                    });
            });
        });

        $ResponsewithoutFilter = $this->getJson('/api/players')
            ->assertStatus(200);

        $ResponsewithoutFilter->assertJsonCount(12);
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
            'team' => [
                'id' => $player->team->id,
                'name' => $player->team->name,
                'slug' => $player->team->slug,
            ],
            'average' => [
                'min' => $player->average['min'],
                'pts' => $player->average['pts'],
                'reb' => $player->average['reb'],
                'ast' => $player->average['ast'],
                'stl' => $player->average['stl'],
                'blk' => $player->average['blk'],
            ],
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
            'league' => $player->league,
            'team' => [
                'id' => $player->team->id,
                'name' => $player->team->name,
                'slug' => $player->team->slug,
            ],
        ]);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->hasAll([
                'id',
                'name',
                'age',
                'height',
                'weight',
                'position',
                'league',
                'team',
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
            'league' => $player->league,
            'team' => [
                'id' => $player->team->id,
                'name' => $player->team->name,
                'slug' => $player->team->slug,
            ]
        ]);

        $response->assertJson(function (AssertableJson $json) use ($response) {
            $json->hasAll([
                'id',
                'name',
                'age',
                'height',
                'weight',
                'position',
                'league',
                'team',
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
