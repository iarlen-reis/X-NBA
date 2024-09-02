<?php

namespace App\Services;

use App\Http\Requests\Player\PlayerResquest;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
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

    public function store(PlayerResquest $data)
    {
        $player = $this->playerRepository->store($data->toArray());

        return response()->json(PlayerResource::make($player), 201);
    }

    public function update(PlayerResquest $data, $id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()->json([
                    'message' => 'Invalid ID provided, use a valid UUID.',
                ], 400);
            }

            $player = $this->playerRepository->update($data->toArray(), $id);

            return response()->json(PlayerResource::make($player), 200);
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
