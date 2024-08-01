<?php

namespace App\Repositories\Implementations;

use App\Repositories\Contracts\TeamRepositoryInterface;
use App\Models\Team;

class TeamRepository implements TeamRepositoryInterface
{
    public function index(string $league)
    {
        if (!$league) {
            return Team::all();
        }

        return Team::where('league', $league)->get();
    }

    public function show(string $id)
    {
        return Team::findOrFail($id);
    }
}
