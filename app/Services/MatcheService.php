<?php

namespace App\Services;

use App\Repositories\Contracts\MatcheRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Str;

class MatcheService
{
    public function __construct(private MatcheRepositoryInterface $repository) {}

    public function index(HttpRequest $request)
    {
        $slug = $request->query('slug') ?? '';

        $matches = $this->repository->index($slug);

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

            $match = $this->repository->show($id);

            return response()->json($match);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Match not found.',
            ], 404);
        }
    }

    public function store(array $data)
    {
        $match = $this->repository->store($data);

        return response()->json($match, 201);
    }

    public function update(array $data, $id)
    {
        try {
            if (!Str::isUuid($id)) {
                return response()->json([
                    'message' => 'Invalid ID provided, use a valid UUID.',
                ], 400);
            }

            $match = $this->repository->update($data, $id);

            return response()->json($match);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Match not found.',
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

            $match = $this->repository->destroy($id);

            return response()->json($match, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Match not found.',
            ], 404);
        }
    }
}
