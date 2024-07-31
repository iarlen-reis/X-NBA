<?php

namespace App\Services;

use App\Repositories\Contracts\TeamRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class TeamService
{
    private $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function index()
    {
        return response()->json($this->teamRepository->index());
    }

    public function show(string $id)
    {
        if (!Str::isUuid($id)) {
            return response()->json([
                'message' => 'Invalid ID provided, use a valid UUID.',
            ], 400);
        }

        try {
            return response()->json($this->teamRepository->show($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Team not found.',
            ], 404);
        }
    }
}
