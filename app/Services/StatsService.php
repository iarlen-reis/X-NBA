<?php

namespace App\Services;

use App\Http\Requests\Stats\StatsRequest;
use App\Http\Resources\StatsResource;
use App\Repositories\Contracts\StatsRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;


class StatsService
{
    private $statsRepository;
    public function __construct(StatsRepositoryInterface $statsRepository)
    {
        $this->statsRepository = $statsRepository;
    }

    public function index()
    {
        $stats = $this->statsRepository->index();

        return StatsResource::collection($stats);
    }

    public function show($id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()->json([
                    'message' => 'Invalid ID provided, use a valid UUID.',
                ], 400);
            }

            $stat = $this->statsRepository->show($id);

            return StatsResource::make($stat);
        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'Stats not found.'], 404);
        }
    }

    public function store(StatsRequest $data)
    {
        $stat = $this->statsRepository->store($data->toArray());

        return response()->json(StatsResource::make($stat), 201);
    }

    public function update(StatsRequest $data, $id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()->json([
                    'message' => 'Invalid ID provided, use a valid UUID.',
                ], 400);
            }

            $stat = $this->statsRepository->update($data->toArray(), $id);

            return StatsResource::make($stat);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Stats not found.'], 404);
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

            $this->statsRepository->destroy($id);

            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Stats not found.'], 404);
        }
    }
}
