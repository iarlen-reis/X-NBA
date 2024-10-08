<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MatchTeam\MatchTeamRequest;
use App\Services\MatchTeamService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Match-teams")
 */
class MatchesTeamController extends Controller
{
    private $matchTeamService;

    public function __construct(MatchTeamService $matchTeamService)
    {
        $this->matchTeamService = $matchTeamService;
    }

    /**
     * @OA\Get(
     *     path="/api/match-teams",
     *     tags={"Match-teams"},
     *     summary="Get all match teams",
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="id", type="string", example="1"),
     *                  @OA\Property(property="role", type="string", example="home"),
     *                  @OA\Property(property="score", type="number", example=110),
     *                  @OA\Property(property="winner", type="boolean", example=true),
     *                  @OA\Property(property="match", type="object",
     *                      @OA\Property(property="id", type="string", example="1"),
     *                      @OA\Property(property="date", type="string", example="2023-01-01T00:00:00.000000Z"),
     *                      @OA\Property(property="location", type="string", example="Boston, MA"),
     *                      @OA\Property(property="stadium", type="string", example="TD Garden"),
     *                      @OA\Property(property="league", type="string", example="NBA"),
     *                  ),
     *                  @OA\Property(property="team", type="object",
     *                      @OA\Property(property="id", type="string", example="1"),
     *                      @OA\Property(property="name", type="string", example="Los Angeles Lakers"),
     *                      @OA\Property(property="slug", type="string", example="los-angeles-lakers"),
     *                  ),
     *                  @OA\Property(property="statistics", type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="player", type="object",
     *                              @OA\Property(property="id", type="string", example="1"),
     *                              @OA\Property(property="name", type="string", example="LeBron James"),
     *                              @OA\Property(property="position", type="string", example="SF"),
     *                          ),
     *                          @OA\Property(property="player_stats", type="object",
     *                              @OA\Property(property="min", type="number", example=34),
     *                              @OA\Property(property="pts", type="number", example=34),
     *                              @OA\Property(property="reb", type="number", example=34),
     *                              @OA\Property(property="ast", type="number", example=34),
     *                              @OA\Property(property="blk", type="number", example=34),
     *                              @OA\Property(property="stl", type="number", example=34),
     *                          ),
     *                      ),
     *                  ),
     *              )
     *         )
     *     ),
     * )
     */
    public function index()
    {
        return $this->matchTeamService->index();
    }

    /**
     * @OA\Get(
     *     path="/api/match-teams/{id}",
     *     tags={"Match-teams"},
     *     summary="Get a match team",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The match team ID",
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
     *              @OA\Property(property="role", type="string", example="home"),
     *              @OA\Property(property="score", type="number", example=110),
     *              @OA\Property(property="winner", type="boolean", example=true),
     *              @OA\Property(property="match", type="object",
     *                  @OA\Property(property="id", type="string", example="1"),
     *                  @OA\Property(property="date", type="string", example="2023-01-01T00:00:00.000000Z"),
     *                  @OA\Property(property="location", type="string", example="Boston, MA"),
     *                  @OA\Property(property="stadium", type="string", example="TD Garden"),
     *                  @OA\Property(property="league", type="string", example="NBA"),
     *               ),
     *              @OA\Property(property="team", type="object",
     *                  @OA\Property(property="id", type="string", example="1"),
     *                  @OA\Property(property="name", type="string", example="Los Angeles Lakers"),
     *                  @OA\Property(property="slug", type="string", example="los-angeles-lakers"),
     *              ),
     *              @OA\Property(property="statistics", type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="player", type="object",
     *                          @OA\Property(property="id", type="string", example="1"),
     *                          @OA\Property(property="name", type="string", example="LeBron James"),
     *                          @OA\Property(property="position", type="string", example="SF"),
     *                      ),
     *                      @OA\Property(property="player_stats", type="object",
     *                          @OA\Property(property="min", type="number", example=34),
     *                          @OA\Property(property="pts", type="number", example=34),
     *                          @OA\Property(property="reb", type="number", example=34),
     *                          @OA\Property(property="ast", type="number", example=34),
     *                          @OA\Property(property="blk", type="number", example=34),
     *                          @OA\Property(property="stl", type="number", example=34),
     *                      ),
     *                  ),
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Match team not found.")
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
    public function show(Request $request, string $id)
    {
        return $this->matchTeamService->show($id);
    }

    /**
     * @OA\Post(
     *     path="/api/match-teams",
     *     tags={"Match-teams"},
     *     summary="Create a match team",
     *     @OA\RequestBody(
     *         description="Match team data",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="match_id", type="string", example="1"),
     *              @OA\Property(property="team_id", type="string", example="1"),
     *              @OA\Property(property="role", type="string", example="home"),
     *              @OA\Property(property="score", type="number", example=110),
     *              @OA\Property(property="winner", type="boolean", example=true),
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="role", type="string", example="home"),
     *              @OA\Property(property="score", type="number", example=110),
     *              @OA\Property(property="winner", type="boolean", example=true),
     *              @OA\Property(property="match", type="object",
     *                  @OA\Property(property="id", type="string", example="1"),
     *                  @OA\Property(property="date", type="string", example="2023-01-01T00:00:00.000000Z"),
     *                  @OA\Property(property="location", type="string", example="Boston, MA"),
     *                  @OA\Property(property="stadium", type="string", example="TD Garden"),
     *                  @OA\Property(property="league", type="string", example="NBA"),
     *               ),
     *              @OA\Property(property="team", type="object",
     *                  @OA\Property(property="id", type="string", example="1"),
     *                  @OA\Property(property="name", type="string", example="Los Angeles Lakers"),
     *                  @OA\Property(property="slug", type="string", example="los-angeles-lakers"),
     *              ),
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="The match_id field is required."),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  @OA\Property(property="name", type="array", @OA\Items(type="string", example="The match_id field is required."))
     *              ),
     *           )
     *         )
     *      ),
     * )
     */
    public function store(MatchTeamRequest $request)
    {
        return $this->matchTeamService->store($request);
    }

    /**
     * @OA\Put(
     *     path="/api/match-teams/{id}",
     *     tags={"Match-teams"},
     *     summary="Update a match team",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The match team ID",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Match team data",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="match_id", type="string", example="1"),
     *              @OA\Property(property="team_id", type="string", example="1"),
     *              @OA\Property(property="role", type="string", example="home"),
     *              @OA\Property(property="score", type="number", example=110),
     *              @OA\Property(property="winner", type="boolean", example=true),
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="role", type="string", example="home"),
     *              @OA\Property(property="score", type="number", example=110),
     *              @OA\Property(property="winner", type="boolean", example=true),
     *              @OA\Property(property="match", type="object",
     *                  @OA\Property(property="id", type="string", example="1"),
     *                  @OA\Property(property="date", type="string", example="2023-01-01T00:00:00.000000Z"),
     *                  @OA\Property(property="location", type="string", example="Boston, MA"),
     *                  @OA\Property(property="stadium", type="string", example="TD Garden"),
     *                  @OA\Property(property="league", type="string", example="NBA"),
     *               ),
     *              @OA\Property(property="team", type="object",
     *                  @OA\Property(property="id", type="string", example="1"),
     *                  @OA\Property(property="name", type="string", example="Los Angeles Lakers"),
     *                  @OA\Property(property="slug", type="string", example="los-angeles-lakers"),
     *              ),
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Match team not found.")
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
    public function update(MatchTeamRequest $request, string $id)
    {
        return $this->matchTeamService->update($request, $id);
    }


    /**
     * @OA\Delete(
     *     path="/api/match-teams/{id}",
     *     tags={"Match-teams"},
     *     summary="delete a match team",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The match team ID",
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
     *              @OA\Property(property="message", type="string", example="Match team not found.")
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
    public function destroy(Request $request, string $id)
    {
        $match = $this->matchTeamService->destroy($id);

        return $match;
    }
}
