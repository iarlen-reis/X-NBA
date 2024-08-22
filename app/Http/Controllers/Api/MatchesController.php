<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MatcheService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Matches")
 */
class MatchesController extends Controller
{
    private $matcheService;
    public function __construct(MatcheService $matcheService)
    {
        $this->matcheService = $matcheService;
    }

    /**
     * @OA\Get(
     *     path="/api/matches",
     *     tags={"Matches"},
     *     summary="Get all matches",
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="id", type="string", example="1"),
     *                  @OA\Property(property="date", type="string", example="2023-01-01T00:00:00.000000Z"),
     *                  @OA\Property(property="location", type="string", example="Boston, MA"),
     *                  @OA\Property(property="stadium", type="string", example="TD Garden"),
     *                  @OA\Property(property="league", type="string", example="NBA"),
     *                  @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *                  @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *              )
     *         )
     *     ),
     * )
     */
    public function index(Request $request)
    {
        return $this->matcheService->index();
    }

    /**
     * @OA\Get(
     *     path="/api/matches/{id}",
     *     tags={"Matches"},
     *     summary="Get a match",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The match ID",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="date", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="location", type="string", example="Boston, MA"),
     *              @OA\Property(property="stadium", type="string", example="TD Garden"),
     *              @OA\Property(property="league", type="string", example="NBA"),
     *              @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Match not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Invalid ID provided, use a valid UUID.")
     *         )
     *     ),
     * )
     */
    public function show(Request $request, $id)
    {
        return $this->matcheService->show($id);
    }

    /**
     * @OA\Post(
     *     path="/api/matches",
     *     tags={"Matches"},
     *     summary="Create a match",
     *     @OA\RequestBody(
     *         description="Match data",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="date", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="location", type="string", example="Boston, MA"),
     *              @OA\Property(property="stadium", type="string", example="TD Garden"),
     *              @OA\Property(property="league", type="string", example="NBA"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="date", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="location", type="string", example="Boston, MA"),
     *              @OA\Property(property="stadium", type="string", example="TD Garden"),
     *              @OA\Property(property="league", type="string", example="NBA"),
     *              @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="The date field is required."),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  @OA\Property(property="name", type="array", @OA\Items(type="string", example="The date field is required."))
     *              ),
     *           )
     *         )
     * )
     */
    public function store(Request $request)
    {
        return $this->matcheService->store($request->all());
    }

    /**
     * @OA\Put(
     *     path="/api/matches/{id}",
     *     tags={"Matches"},
     *     summary="Update a match",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The match ID",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Match data",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="date", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="location", type="string", example="Boston, MA"),
     *              @OA\Property(property="stadium", type="string", example="TD Garden"),
     *              @OA\Property(property="league", type="string", example="NBA"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="date", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="location", type="string", example="Boston, MA"),
     *              @OA\Property(property="stadium", type="string", example="TD Garden"),
     *              @OA\Property(property="league", type="string", example="NBA"),
     *              @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Match not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Invalid ID provided, use a valid UUID.")
     *         )
     *     ),
     * )
     */
    public function update(Request $request, $id)
    {
        return $this->matcheService->update($request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     path="/api/matches/{id}",
     *     tags={"Matches"},
     *     summary="delete a match",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The match ID",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Success",
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Match not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Invalid ID provided, use a valid UUID.")
     *         )
     *     ),
     * )
     */
    public function destroy($id)
    {
        return $this->matcheService->destroy($id);
    }
}