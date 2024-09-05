<?php

namespace App\Repositories\Implementations;

use App\Models\Stats;
use App\Repositories\Contracts\StatsRepositoryInterface;

class StatsRepository implements StatsRepositoryInterface
{
    public function index()
    {
        return Stats::all();
    }

    public function show($id)
    {
        return Stats::findOrFail($id);
    }

    public function store(array $data)
    {
        return Stats::create($data);
    }

    public function update(array $data, $id)
    {
        $stats = Stats::findOrFail($id);
        $stats->update($data);

        return $stats;
    }

    public function destroy($id)
    {
        $stats = Stats::findOrFail($id);
        $stats->delete();
    }
}
