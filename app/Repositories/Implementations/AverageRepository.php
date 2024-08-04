<?php

namespace App\Repositories\Implementations;

use App\Models\Average;
use App\Repositories\Contracts\AverageRepositoryInterface;

class AverageRepository implements AverageRepositoryInterface
{
    public function index()
    {
        return Average::all()->load('player');
    }

    public function show($id)
    {
        return Average::findOrFail($id)->load('player');
    }

    public function store(array $data)
    {
        $average = Average::create($data);

        return $average;
    }

    public function update(array $data, $id)
    {
        $average = Average::findOrFail($id);

        $average->update($data);

        return $average;
    }

    public function destroy($id)
    {
        $average = Average::findOrFail($id);

        $average->delete();

        return $average;
    }
}
