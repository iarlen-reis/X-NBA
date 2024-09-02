<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Player\StorePlayerRequest;
use App\Services\PlayerService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Players")
 */
class PlayersController extends Controller
{
    private $playerService;
    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

    /**
     * @OA\Get(
     *     path="/api/players",
     *     tags={"Players"},
     *     summary="Get all players",
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="id", type="string", example="1"),
     *                  @OA\Property(property="name", type="string", example="Player 1"),
     *                  @OA\Property(property="age", type="integer", example="25"),
     *                  @OA\Property(property="height", type="integer", example="180"),
     *                  @OA\Property(property="weight", type="integer", example="80"),
     *                  @OA\Property(property="position", type="string", example="C"),
     *                  @OA\Property(property="league", type="string", example="League 1"),
     *                  @OA\Property(property="average", type="object",
     *                      @OA\Property(property="pts", type="string", example="10"),
     *                      @OA\Property(property="reb", type="string", example="10"),
     *                      @OA\Property(property="ast", type="string", example="10"),
     *                      @OA\Property(property="stl", type="string", example="10"),
     *                      @OA\Property(property="blk", type="string", example="10"),
     *                  ),
     *                  @OA\Property(property="team", type="object",
     *                      @OA\Property(property="id", type="string", example="1"),
     *                      @OA\Property(property="name", type="string", example="Team 1"),
     *                      @OA\Property(property="slug", type="string", example="team-1"),
     *                  ),
     *              )
     *         )
     *     ),
     * )
     */
    public function index(Request $request)
    {
        return $this->playerService->index($request);
    }

    /**
     * @OA\Get(
     *     path="/api/players/{id}",
     *     tags={"Players"},
     *     summary="Get a player",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The player ID",
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
     *              @OA\Property(property="name", type="string", example="Player 1"),
     *              @OA\Property(property="age", type="integer", example="25"),
     *              @OA\Property(property="height", type="integer", example="180"),
     *              @OA\Property(property="weight", type="integer", example="80"),
     *              @OA\Property(property="position", type="string", example="C"),
     *              @OA\Property(property="league", type="string", example="League 1"),
     *              @OA\Property(property="average", type="object",
     *                  @OA\Property(property="pts", type="string", example="10"),
     *                  @OA\Property(property="reb", type="string", example="10"),
     *                  @OA\Property(property="ast", type="string", example="10"),
     *                  @OA\Property(property="stl", type="string", example="10"),
     *                  @OA\Property(property="blk", type="string", example="10"),
     *              ),
     *              @OA\Property(property="team", type="object",
     *                  @OA\Property(property="id", type="string", example="1"),
     *                  @OA\Property(property="name", type="string", example="Team 1"),
     *                  @OA\Property(property="slug", type="string", example="team-1"),
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Player not found.")
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
        return $this->playerService->show($id);
    }

    /**
     * @OA\Post(
     *     path="/api/players",
     *     tags={"Players"},
     *     summary="Create a player",
     *     @OA\RequestBody(
     *         description="Player data",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Michael Jordan"),
     *              @OA\Property(property="age", type="interger", example=25),
     *              @OA\Property(property="height", type="interger", example=180),
     *              @OA\Property(property="weight", type="interger", example=80),
     *              @OA\Property(property="position", type="string", example="C"),
     *              @OA\Property(property="league", type="string", example="NBA"),
     *              @OA\Property(property="team_id", type="string", example="1")
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="name", type="string", example="Player 1"),
     *              @OA\Property(property="age", type="integer", example="25"),
     *              @OA\Property(property="height", type="integer", example="180"),
     *              @OA\Property(property="weight", type="integer", example="80"),
     *              @OA\Property(property="position", type="string", example="C"),
     *              @OA\Property(property="league", type="string", example="NBA"),
     *              @OA\Property(property="team_id", type="string", example="1"),
     *              @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="The name field is required."),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  @OA\Property(property="name", type="array", @OA\Items(type="string", example="The name field is required."))
     *              ),
     *           )
     *         )
     *      ),
     * )
     */
    public function store(StorePlayerRequest $request)
    {
        $request->validated();

        return $this->playerService->store($request);
    }

    /**
     *  @OA\Put(
     *     path="/api/players/{id}",
     *     tags={"Players"},
     *     summary="Update a player",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The player ID",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Player data",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Michael Jordan"),
     *              @OA\Property(property="age", type="interger", example=25),
     *              @OA\Property(property="height", type="interger", example=180),
     *              @OA\Property(property="weight", type="interger", example=80),
     *              @OA\Property(property="position", type="string", example="C"),
     *              @OA\Property(property="league", type="string", example="NBA"),
     *              @OA\Property(property="team_id", type="string", example="1")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="name", type="string", example="Player 1"),
     *              @OA\Property(property="age", type="integer", example="25"),
     *              @OA\Property(property="height", type="integer", example="180"),
     *              @OA\Property(property="weight", type="integer", example="80"),
     *              @OA\Property(property="position", type="string", example="C"),
     *              @OA\Property(property="league", type="string", example="NBA"),
     *              @OA\Property(property="active", type="boolean", example="true"),
     *              @OA\Property(property="team_id", type="string", example="1"),
     *              @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Player not found.")
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
    public function update(StorePlayerRequest $request, $id)
    {
        $request->validated();

        return $this->playerService->update($request, $id);
    }

    /**
     * @OA\Delete(
     *     path="/api/players/{id}",
     *     tags={"Players"},
     *     summary="Soft delete a player",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The player ID",
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
     *              @OA\Property(property="message", type="string", example="Player not found.")
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
    public function destroy(Request $request, $id)
    {
        return $this->playerService->destroy($id);
    }
}
