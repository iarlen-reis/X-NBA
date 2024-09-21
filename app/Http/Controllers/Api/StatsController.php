<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stats\StatsRequest;
use App\Services\StatsService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Stats")
 */
class StatsController extends Controller
{
    private $statsService;
    public function __construct(StatsService $statsService)
    {
        $this->statsService = $statsService;
    }

    /**
     * @OA\Get(
     *     path="/api/stats",
     *     tags={"Stats"},
     *     summary="Get all stats",
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="1"),
     *                 @OA\Property(
     *                     property="player",
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="1"),
     *                     @OA\Property(property="name", type="string", example="Stephen Curry"),
     *                     @OA\Property(property="position", type="string", example="PG")
     *                 ),
     *                 @OA\Property(
     *                     property="stats",
     *                     type="object",
     *                     @OA\Property(property="min", type="integer", example=10),
     *                     @OA\Property(property="pts", type="integer", example=10),
     *                     @OA\Property(property="reb", type="integer", example=10),
     *                     @OA\Property(property="ast", type="integer", example=10),
     *                     @OA\Property(property="blk", type="integer", example=10),
     *                     @OA\Property(property="stl", type="integer", example=10)
     *                 ),
     *                 @OA\Property(
     *                     property="match",
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="1"),
     *                     @OA\Property(property="date", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
     *                 ),
     *                 @OA\Property(
     *                     property="match_team",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="string", example="1"),
     *                         @OA\Property(property="role", type="string", example="home"),
     *                         @OA\Property(property="score", type="number", format="float", example=110),
     *                         @OA\Property(property="winner", type="boolean", example=true),
     *                         @OA\Property(
     *                             property="team",
     *                             type="object",
     *                             @OA\Property(property="id", type="string", example="1"),
     *                             @OA\Property(property="name", type="string", example="Boston Celtics"),
     *                             @OA\Property(property="slug", type="string", example="boston-celtics")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return $this->statsService->index();
    }

    /**
     * @OA\Get(
     *      path="/api/stats/{id}",
     *      tags={"Stats"},
     *      summary="Get stats by id",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Stats id",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\JsonContent(
     *              type="object",
     *               @OA\Property(property="id", type="string", example="1"),
     *               @OA\Property(property="player", type="object",
     *                   @OA\Property(property="id", type="string", example="1"),
     *                   @OA\Property(property="name", type="string", example="Stephen Curry"),
     *                   @OA\Property(property="position", type="string", example="PG")
     *               ),
     *               @OA\Property(property="stats", type="object",
     *                   @OA\Property(property="min", type="integer", example=10),
     *                   @OA\Property(property="pts", type="integer", example=10),
     *                   @OA\Property(property="reb", type="integer", example=10),
     *                   @OA\Property(property="ast", type="integer", example=10),
     *                   @OA\Property(property="blk", type="integer", example=10),
     *                   @OA\Property(property="stl", type="integer", example=10)
     *               ),
     *               @OA\Property(property="match", type="object",
     *                   @OA\Property(property="id", type="string", example="1"),
     *                   @OA\Property(property="date", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
     *               ),
     *               @OA\Property(property="match_team", type="array",
     *                   @OA\Items(
     *                       type="object",
     *                       @OA\Property(property="id", type="string", example="1"),
     *                       @OA\Property(property="role", type="string", example="home"),
     *                       @OA\Property(property="score", type="number", format="float", example=110),
     *                       @OA\Property(property="winner", type="boolean", example=true),
     *                       @OA\Property(
     *                           property="team",
     *                           type="object",
     *                           @OA\Property(property="id", type="string", example="1"),
     *                           @OA\Property(property="name", type="string", example="Boston Celtics"),
     *                           @OA\Property(property="slug", type="string", example="boston-celtics")
     *                       )
     *                   )
     *               )
     *           )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Stats not found."),
     *          )
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Bad request",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Invalid ID provided, use a valid UUID."),
     *          )
     *      ),
     * )
     */
    public function show(Request $request, string $id)
    {
        return $this->statsService->show($id);
    }

    /**
     * @OA\Post(
     *      path="/api/stats",
     *      tags={"Stats"},
     *      summary="Store stats",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="min", type="integer", example=10),
     *              @OA\Property(property="pts", type="integer", example=10),
     *              @OA\Property(property="reb", type="integer", example=10),
     *              @OA\Property(property="ast", type="integer", example=10),
     *              @OA\Property(property="blk", type="integer", example=10),
     *              @OA\Property(property="stl", type="integer", example=10),
     *              @OA\Property(property="player_id", type="string", example="1"),
     *              @OA\Property(property="match_team_id", type="string", example="1"),
     *          )
     *      ),
     *      @OA\Response(
     *          response="201",
     *          description="Success",
     *          @OA\JsonContent(
     *              type="object",
     *               @OA\Property(property="id", type="string", example="1"),
     *               @OA\Property(property="player", type="object",
     *                   @OA\Property(property="id", type="string", example="1"),
     *                   @OA\Property(property="name", type="string", example="Stephen Curry"),
     *                   @OA\Property(property="position", type="string", example="PG")
     *               ),
     *               @OA\Property(property="stats", type="object",
     *                   @OA\Property(property="min", type="integer", example=10),
     *                   @OA\Property(property="pts", type="integer", example=10),
     *                   @OA\Property(property="reb", type="integer", example=10),
     *                   @OA\Property(property="ast", type="integer", example=10),
     *                   @OA\Property(property="blk", type="integer", example=10),
     *                   @OA\Property(property="stl", type="integer", example=10)
     *               ),
     *               @OA\Property(property="match", type="object",
     *                   @OA\Property(property="id", type="string", example="1"),
     *                   @OA\Property(property="date", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
     *               ),
     *               @OA\Property(property="match_team", type="array",
     *                   @OA\Items(
     *                       type="object",
     *                       @OA\Property(property="id", type="string", example="1"),
     *                       @OA\Property(property="role", type="string", example="home"),
     *                       @OA\Property(property="score", type="number", format="float", example=110),
     *                       @OA\Property(property="winner", type="boolean", example=true),
     *                       @OA\Property(
     *                           property="team",
     *                           type="object",
     *                           @OA\Property(property="id", type="string", example="1"),
     *                           @OA\Property(property="name", type="string", example="Boston Celtics"),
     *                           @OA\Property(property="slug", type="string", example="boston-celtics")
     *                       )
     *                   )
     *               )
     *           )
     *      ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="The pts field is required."),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  @OA\Property(property="pts", type="array", @OA\Items(type="string", example="The pts field is required."))
     *              ),
     *           )
     *         )
     *      ),
     * )
     */
    public function store(StatsRequest $request)
    {
        $request->validated();

        return $this->statsService->store($request);
    }

    /**
     * @OA\Put(
     *      path="/api/stats/{id}",
     *      tags={"Stats"},
     *      summary="Update stats",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string"),
     *          description="Stats ID",
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="min", type="integer", example=10),
     *              @OA\Property(property="pts", type="integer", example=10),
     *              @OA\Property(property="reb", type="integer", example=10),
     *              @OA\Property(property="ast", type="integer", example=10),
     *              @OA\Property(property="blk", type="integer", example=10),
     *              @OA\Property(property="stl", type="integer", example=10),
     *              @OA\Property(property="player_id", type="string", example="1"),
     *              @OA\Property(property="match_team_id", type="string", example="1"),
     *          )
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\JsonContent(
     *              type="object",
     *               @OA\Property(property="id", type="string", example="1"),
     *               @OA\Property(property="player", type="object",
     *                   @OA\Property(property="id", type="string", example="1"),
     *                   @OA\Property(property="name", type="string", example="Stephen Curry"),
     *                   @OA\Property(property="position", type="string", example="PG")
     *               ),
     *               @OA\Property(property="stats", type="object",
     *                   @OA\Property(property="min", type="integer", example=10),
     *                   @OA\Property(property="pts", type="integer", example=10),
     *                   @OA\Property(property="reb", type="integer", example=10),
     *                   @OA\Property(property="ast", type="integer", example=10),
     *                   @OA\Property(property="blk", type="integer", example=10),
     *                   @OA\Property(property="stl", type="integer", example=10)
     *               ),
     *               @OA\Property(property="match", type="object",
     *                   @OA\Property(property="id", type="string", example="1"),
     *                   @OA\Property(property="date", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
     *               ),
     *               @OA\Property(property="match_team", type="array",
     *                   @OA\Items(
     *                       type="object",
     *                       @OA\Property(property="id", type="string", example="1"),
     *                       @OA\Property(property="role", type="string", example="home"),
     *                       @OA\Property(property="score", type="number", format="float", example=110),
     *                       @OA\Property(property="winner", type="boolean", example=true),
     *                       @OA\Property(
     *                           property="team",
     *                           type="object",
     *                           @OA\Property(property="id", type="string", example="1"),
     *                           @OA\Property(property="name", type="string", example="Boston Celtics"),
     *                           @OA\Property(property="slug", type="string", example="boston-celtics")
     *                       )
     *                   )
     *               )
     *           )
     *      ),
     *     @OA\Response(
     *         response="404",
     *         description="Not found",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Stats not found")
     *          )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="The pts field is required."),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  @OA\Property(property="pts", type="array", @OA\Items(type="string", example="The pts field is required."))
     *              ),
     *           )
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Bad request",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Invalid ID provided, use a valid UUID."),
     *          )
     *      ),
     * ),
     */
    public function update(StatsRequest $request, string $id)
    {
        $request->validated();

        return $this->statsService->update($request, $id);
    }

    /**
     * @OA\Delete(
     *      path="/api/stats/{id}",
     *      tags={"Stats"},
     *      summary="Delete stats",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string"),
     *          description="Stats ID",
     *      ),
     *      @OA\Response(
     *          response="204",
     *          description="No content",
     *      ),
     *     @OA\Response(
     *         response="404",
     *         description="Not found",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Stats not found")
     *          )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad request",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Invalid ID provided, use a valid UUID."),
     *          )
     *      ),
     * )
     */
    public function destroy(string $id)
    {
        return $this->statsService->destroy($id);
    }
}
