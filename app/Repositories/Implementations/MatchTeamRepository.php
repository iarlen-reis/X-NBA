<?php

namespace App\Repositories\Implementations;

use App\Repositories\Contracts\MatchTeamRepositoryInterface;
use App\Models\MatchTeam;

class MatchTeamRepository implements MatchTeamRepositoryInterface
{
    public function index()
    {
        return MatchTeam::all()->load(['match', 'team']);
    }

    public function show($id)
    {
        return MatchTeam::findOrFail($id);
    }

    public function store($data)
    {
        return MatchTeam::create($data);
    }

    public function update($data, $id)
    {
        $matcheTeam = MatchTeam::findOrFail($id);

        $matcheTeam->update($data);

        return $matcheTeam;
    }

    public function destroy($id)
    {
        $matcheTeam = MatchTeam::findOrFail($id);

        $matcheTeam->delete();

        return;
    }
}