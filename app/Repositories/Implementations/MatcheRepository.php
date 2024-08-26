<?php

namespace App\Repositories\Implementations;

use App\Models\Matche;
use App\Repositories\Contracts\MatcheRepositoryInterface;

class MatcheRepository implements MatcheRepositoryInterface
{
    public function index()
    {
        return Matche::all()->load(['matchesTeams.team']);
    }

    public function show($id)
    {
        return Matche::findOrFail($id)->load(['matchesTeams.team']);
    }

    public function store(array $data)
    {
        return Matche::create($data);
    }

    public function update(array $data, $id)
    {
        $matche = Matche::findOrFail($id);

        $matche->update($data);

        return $matche;
    }

    public function destroy($id)
    {
        $matche = Matche::findOrFail($id);

        $matche->delete();

        return $matche;
    }
}
