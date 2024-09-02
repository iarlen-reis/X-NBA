<?php

namespace App\Repositories\Implementations;

use App\Models\Player;
use App\Repositories\Contracts\PlayerRepositoryInterface;

class PlayerRepository implements PlayerRepositoryInterface
{
    public function index(string $team)
    {
        if (!$team) {
            return Player::with('average')->get();
        }

        return Player::with(['team'])->whereHas('team', function ($query) use ($team) {
            return $query->where('slug', $team);
        })->with('average')->get();
    }

    public function show($id)
    {
        return Player::findOrFail($id)->load(['team', 'average']);
    }

    public function store(array $data)
    {
        return Player::create($data);
    }

    public function update(array $data, $id)
    {
        $player = Player::findOrFail($id);

        $player->update($data);

        return $player;
    }

    public function destroy($id)
    {
        $player = Player::findOrFail($id);

        $player->update(['active' => !$player->active]);

        return $player;
    }
}
