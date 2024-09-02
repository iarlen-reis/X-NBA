<?php

namespace App\Services;

use App\Http\Requests\Average\AverageRequest;
use App\Http\Resources\AverageResource;
use App\Repositories\Implementations\AverageRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AverageService
{
    private $averageRepository;
    public function __construct(AverageRepository $averageRepository)
    {
        $this->averageRepository = $averageRepository;
    }
    public function index()
    {
        $avareges = $this->averageRepository->index();

        return AverageResource::collection($avareges);
    }

    public function show($id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()
                    ->json(['message' => 'Invalid ID provided, use a valid UUID.'], 400);
            }

            $average = $this->averageRepository->show($id);

            return AverageResource::make($average);
        } catch (ModelNotFoundException $e) {
            return response()
                ->json(['message' => 'Average not found.'], 404);
        }
    }

    public function store(AverageRequest $data)
    {
        $average = $this->averageRepository->store($data->toArray());

        return response()->json(AverageResource::make($average), 201);
    }

    public function update(AverageRequest $data, $id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()
                    ->json(['message' => 'Invalid ID provided, use a valid UUID.'], 400);
            }

            $average = $this->averageRepository->update($data->toArray(), $id);

            return AverageResource::make($average);
        } catch (ModelNotFoundException $e) {
            return response()
                ->json(['message' => 'Average not found.'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()
                    ->json(['message' => 'Invalid ID provided, use a valid UUID.'], 400);
            }

            $this->averageRepository->destroy($id);

            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            return response()
                ->json(['message' => 'Average not found.'], 404);
        }
    }
}
