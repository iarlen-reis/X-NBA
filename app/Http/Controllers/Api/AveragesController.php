<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AverageService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Averages")
 */
class AveragesController extends Controller
{
    private $averageService;
    public function __construct(AverageService $averageService)
    {
        $this->averageService = $averageService;
    }

    /**
     * @OA\Get(
     *     path="/api/averages",
     *     tags={"Averages"},
     *     summary="Get all averages",
     *     @OA\Response(
     *         response="200", description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="1"),
     *                 @OA\Property(property="pts", type="integer", example="25"),
     *                 @OA\Property(property="reb", type="integer", example="25"),
     *                 @OA\Property(property="ast", type="integer", example="25"),
     *                 @OA\Property(property="stl", type="integer", example="25"),
     *                 @OA\Property(property="blk", type="integer", example="25"),
     *                 @OA\Property(property="player_id", type="string", example="1"),
     *                 @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *                 @OA\Property(property="player", type="object",
     *                     @OA\Property(property="id", type="string", example="1"),
     *                     @OA\Property(property="name", type="string", example="Player 1"),
     *                     @OA\Property(property="age", type="integer", example="25"),
     *                     @OA\Property(property="height", type="integer", example="180"),
     *                     @OA\Property(property="weight", type="integer", example="80"),
     *                     @OA\Property(property="position", type="string", example="Center"),
     *                     @OA\Property(property="league", type="string", example="League 1"),
     *                     @OA\Property(property="team_id", type="string", example="1"),
     *                     @OA\Property(property="active", type="boolean", example="true"),
     *                     @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        return $this->averageService->index();
    }

    /**
     * @OA\Get(
     *     path="/api/averages/{id}",
     *     tags={"Averages"},
     *     summary="Get an average",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The average ID",
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
     *              @OA\Property(property="pts", type="integer", example="25"),
     *              @OA\Property(property="reb", type="integer", example="25"),
     *              @OA\Property(property="ast", type="integer", example="25"),
     *              @OA\Property(property="stl", type="integer", example="25"),
     *              @OA\Property(property="blk", type="integer", example="25"),
     *              @OA\Property(property="player_id", type="string", example="1"),
     *              @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="player", type="object",
     *                  @OA\Property(property="id", type="string", example="1"),
     *                  @OA\Property(property="name", type="string", example="Player 1"),
     *                  @OA\Property(property="age", type="integer", example="25"),
     *                  @OA\Property(property="height", type="integer", example="180"),
     *                  @OA\Property(property="weight", type="integer", example="80"),
     *                  @OA\Property(property="position", type="string", example="Center"),
     *                  @OA\Property(property="league", type="string", example="League 1"),
     *                  @OA\Property(property="team_id", type="string", example="1"),
     *                  @OA\Property(property="active", type="boolean", example="true"),
     *                  @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *                  @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Average not found.")
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
        return $this->averageService->show($id);
    }

    /**
     * @OA\Post(
     *     path="/api/averages",
     *     tags={"Averages"},
     *     summary="Create an average",
     *     @OA\RequestBody(
     *         description="Average data",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="pts", type="interger", example=25),
     *              @OA\Property(property="reb", type="interger", example=25),
     *              @OA\Property(property="ast", type="interger", example=25),
     *              @OA\Property(property="stl", type="interger", example=25),
     *              @OA\Property(property="blk", type="interger", example=25),
     *              @OA\Property(property="player_id", type="string", example="1")
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="pts", type="integer", example="25"),
     *              @OA\Property(property="reb", type="integer", example="25"),
     *              @OA\Property(property="ast", type="integer", example="25"),
     *              @OA\Property(property="stl", type="integer", example="25"),
     *              @OA\Property(property="blk", type="integer", example="25"),
     *              @OA\Property(property="player_id", type="string", example="1"),
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
    public function store(Request $request)
    {
        return $this->averageService->store($request);
    }

    /**
     * @OA\Put(
     *     path="/api/averages/{id}",
     *     tags={"Averages"},
     *     summary="Update an average",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The average ID",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Average data",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="pts", type="interger", example=25),
     *              @OA\Property(property="reb", type="interger", example=25),
     *              @OA\Property(property="ast", type="interger", example=25),
     *              @OA\Property(property="stl", type="interger", example=25),
     *              @OA\Property(property="blk", type="interger", example=25)
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="pts", type="integer", example="25"),
     *              @OA\Property(property="reb", type="integer", example="25"),
     *              @OA\Property(property="ast", type="integer", example="25"),
     *              @OA\Property(property="stl", type="integer", example="25"),
     *              @OA\Property(property="blk", type="integer", example="25"),
     *              @OA\Property(property="player_id", type="string", example="1"),
     *              @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Average not found.")
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
        return $this->averageService->update($request, $id);
    }

    /**
     * @OA\Delete(
     *     path="/api/averages/{id}",
     *     tags={"Averages"},
     *     summary="Delete an average",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The average ID",
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
     *              @OA\Property(property="message", type="string", example="Average not found.")
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
        return $this->averageService->destroy($id);
    }
}
