<?php

namespace App\Services;

use App\Http\Resources\PlayerResource;
use App\Repositories\Contracts\PlayerRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlayerService
{
    private $playerRepository;

    public function __construct(
        PlayerRepositoryInterface $playerRepository
    ) {

        $this->playerRepository = $playerRepository;
    }

    public function index(Request $request)
    {
        $team = $request->query('team') ?? '';

        $players = $this->playerRepository->index($team);

        return PlayerResource::collection($players);
    }

    public function show($id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()->json([
                    'message' => 'Invalid ID provided, use a valid UUID.',
                ], 400);
            }

            $player = $this->playerRepository->show($id);

            return PlayerResource::make($player);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Player not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $player = $this->playerRepository->store($request->all());

        return response()->json($player, 201);
    }

    public function update(Request $request, $id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()->json([
                    'message' => 'Invalid ID provided, use a valid UUID.',
                ], 400);
            }

            $player = $this->playerRepository->update($request->all(), $id);

            return response()->json($player, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Player not found.'], 404);
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

            $player = $this->playerRepository->destroy($id);

            return response()->json($player, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Player not found.'], 404);
        }
    }
}
