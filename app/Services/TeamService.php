<?php

namespace App\Services;

use App\Http\Requests\Team\TeamRequest;
use App\Http\Resources\TeamResource;
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

        return TeamResource::collection($teams);
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

            return TeamResource::make($team);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Team not found.',
            ], 404);
        }
    }

    public function store(TeamRequest $data)
    {
        $team = $this->teamRepository->store($data->toArray());

        return response()->json(TeamResource::make($team), 201);
    }

    public function update(TeamRequest $data, string $id)
    {
        try {

            if (!Str::isUuid($id)) {
                return response()->json([
                    'message' => 'Invalid ID provided, use a valid UUID.',
                ], 400);
            }

            $team = $this->teamRepository->update($id, $data->toArray());

            return response()->json(TeamResource::make($team));
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
