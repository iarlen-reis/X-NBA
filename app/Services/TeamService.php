<?php

namespace App\Services;

use App\Repositories\Contracts\TeamRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamService
{
    private $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function index(Request $request)
    {
        $league = str($request->query('league'))->upper()->value();

        $teams = $this->teamRepository->index($league);

        return response()->json($teams);
    }

    public function show(string $id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()->json([
                    'message' => 'Invalid ID provided, use a valid UUID.',
                ], 400);
            }

            $team = $this->teamRepository->show($id);

            return response()->json($team);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Team not found.',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $team = $this->teamRepository->store($request->all());

        return response()->json($team, 201);
    }

    public function update(Request $request, string $id)
    {
        try {

            if (!Str::isUuid($id)) {
                return response()->json([
                    'message' => 'Invalid ID provided, use a valid UUID.',
                ], 400);
            }

            $team = $this->teamRepository->update($id, $request->all());

            return response()->json($team);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Team not found.',
            ], 404);
        }
    }

    public function destroy(string $id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()->json([
                    'message' => 'Invalid ID provided, use a valid UUID.',
                ], 400);
            }

            $this->teamRepository->destroy($id);

            return response()->json(status: 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Team not found.',
            ], 404);
        }
    }
}
