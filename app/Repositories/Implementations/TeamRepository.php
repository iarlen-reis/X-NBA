<?php

namespace App\Repositories\Implementations;

use App\Repositories\Contracts\TeamRepositoryInterface;
use App\Models\Team;

class TeamRepository implements TeamRepositoryInterface
{
    public function index(string $league)
    {
        if (!$league) {
            return Team::where('active', true)->get();
        }

        return Team::where('league', $league)->get();
    }

    public function show(string $id)
    {
        return Team::findOrFail($id)->load('players');
    }

    public function store(array $data)
    {
        return Team::create($data);
    }

    public function update(string $id, array $data)
    {
        $team = Team::findOrFail($id);

        $team->update($data);

        return $team;
    }

    public function destroy(string $id)
    {
        $team = Team::findOrFail($id);

        $team->update([
            'active' => !$team->active,
        ]);

        return $team;
    }
}
