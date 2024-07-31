<?php

namespace App\Repositories\Implementations;

use App\Repositories\Contracts\TeamRepositoryInterface;
use App\Models\Team;

class TeamRepository implements TeamRepositoryInterface
{
    public function index()
    {
        return Team::all();
    }

    public function show(string $id)
    {
        return Team::findOrFail($id);
    }
}
