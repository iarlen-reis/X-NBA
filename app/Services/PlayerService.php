<?php

namespace App\Services;

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

    public function index()
    {
        $players = $this->playerRepository->index();

        return response()->json($players);
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

            return response()->json($player);
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
