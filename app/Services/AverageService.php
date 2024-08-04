<?php

namespace App\Services;

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

        return response()->json($avareges);
    }

    public function show($id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()
                    ->json(['message' => 'Invalid ID provided, use a valid UUID.'], 400);
            }

            $average = $this->averageRepository->show($id);

            return response()->json($average);
        } catch (ModelNotFoundException $e) {
            return response()
                ->json(['message' => 'Average not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $average = $this->averageRepository->store($request->all());

        return response()->json($average, 201);
    }

    public function update(Request $request, $id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()
                    ->json(['message' => 'Invalid ID provided, use a valid UUID.'], 400);
            }

            $average = $this->averageRepository->update($request->all(), $id);

            return response()->json($average);
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
