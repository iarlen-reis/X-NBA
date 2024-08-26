<?php

namespace App\Services;

use App\Repositories\Contracts\MatchTeamRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class MatchTeamService
{
    private MatchTeamRepositoryInterface $matchTeamRepository;

    public function __construct(MatchTeamRepositoryInterface $matchTeamRepository)
    {
        $this->matchTeamRepository = $matchTeamRepository;
    }

    public function index()
    {
        $matches = $this->matchTeamRepository->index();

        return response()->json($matches);
    }

    public function show($id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()->json([
                    'message' => 'Invalid ID provided, use a valid UUID.',
                ], 400);
            }

            $match = $this->matchTeamRepository->show($id);

            return response()->json($match);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Match team not found.',
            ], 404);
        }
    }

    public function store($data)
    {
        $match = $this->matchTeamRepository->store($data);

        return response()->json($match, 201);
    }

    public function update($data, $id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()->json([
                    'message' => 'Invalid ID provided, use a valid UUID.',
                ], 400);
            }

            $match = $this->matchTeamRepository->update($data, $id);

            return response()->json($match);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Match team not found.',
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()->json([
                    'message' => 'Invalid ID provided, use a valid UUID.',
                ], 400);
            }

            $this->matchTeamRepository->destroy($id);

            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Match team not found.',
            ], 404);
        }
    }
}
