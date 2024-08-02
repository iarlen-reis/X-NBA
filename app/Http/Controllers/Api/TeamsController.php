<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Services\TeamService;

use Illuminate\Http\Request;


/**
 * @OA\Tag(name="Teams")
 */
class TeamsController extends Controller
{
    private $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * @OA\Get(
     *     path="/api/teams",
     *     tags={"Teams"},
     *     summary="Get all teams",
     *     @OA\Parameter(
     *         name="league",
     *         in="query",
     *         description="Filter teams by league",
     *         @OA\Schema(
     *             type="string",
     *             enum={"NBA", "WNBA"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="id", type="string", example="1"),
     *                  @OA\Property(property="name", type="string", example="Team 1"),
     *                  @OA\Property(property="slug", type="string", example="team-1"),
     *                  @OA\Property(property="stadium", type="string", example="Stadium 1"),
     *                  @OA\Property(property="city", type="string", example="City 1"),
     *                  @OA\Property(property="country", type="string", example="Country 1"),
     *                  @OA\Property(property="coach", type="string", example="Coach 1"),
     *                  @OA\Property(property="league", type="string", example="League 1"),
     *                  @OA\Property(property="active", type="boolean", example="true"),
     *                  @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *                  @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *              )
     *         )
     *     ),
     * )
     */
    public function index(Request $request)
    {
        return $this->teamService->index($request);
    }

    /**
     * @OA\Get(
     *     path="/api/teams/{id}",
     *     tags={"Teams"},
     *     summary="Get a team",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The team ID",
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
     *              @OA\Property(property="name", type="string", example="Team 1"),
     *              @OA\Property(property="slug", type="string", example="team-1"),
     *              @OA\Property(property="stadium", type="string", example="Stadium 1"),
     *              @OA\Property(property="city", type="string", example="City 1"),
     *              @OA\Property(property="country", type="string", example="Country 1"),
     *              @OA\Property(property="coach", type="string", example="Coach 1"),
     *              @OA\Property(property="league", type="string", example="League 1"),
     *              @OA\Property(property="active", type="boolean", example="true"),
     *              @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Team not found.")
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
    public function show(string $id)
    {
        return $this->teamService->show($id);
    }

    /**
     * @OA\Post(
     *     path="/api/teams",
     *     tags={"Teams"},
     *     summary="Create a team",
     *     @OA\RequestBody(
     *         description="Team data",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Team 1"),
     *              @OA\Property(property="slug", type="string", example="team-1"),
     *              @OA\Property(property="stadium", type="string", example="Stadium 1"),
     *              @OA\Property(property="city", type="string", example="City 1"),
     *              @OA\Property(property="country", type="string", example="Country 1"),
     *              @OA\Property(property="coach", type="string", example="Coach 1"),
     *              @OA\Property(property="league", type="string", example="League 1")
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="name", type="string", example="Team 1"),
     *              @OA\Property(property="slug", type="string", example="team-1"),
     *              @OA\Property(property="stadium", type="string", example="Stadium 1"),
     *              @OA\Property(property="city", type="string", example="City 1"),
     *              @OA\Property(property="country", type="string", example="Country 1"),
     *              @OA\Property(property="coach", type="string", example="Coach 1"),
     *              @OA\Property(property="league", type="string", example="League 1"),
     *              @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *         )
     *     ),
     * )
     */
    public function store(Request $request)
    {
        return $this->teamService->store($request);
    }

    /**
     * @OA\Put(
     *     path="/api/teams/{id}",
     *     tags={"Teams"},
     *     summary="Update a team",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The team ID",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Team data",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Team 1"),
     *              @OA\Property(property="slug", type="string", example="team-1"),
     *              @OA\Property(property="stadium", type="string", example="Stadium 1"),
     *              @OA\Property(property="city", type="string", example="City 1"),
     *              @OA\Property(property="country", type="string", example="Country 1"),
     *              @OA\Property(property="coach", type="string", example="Coach 1"),
     *              @OA\Property(property="league", type="string", example="League 1")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="name", type="string", example="Team 1"),
     *              @OA\Property(property="slug", type="string", example="team-1"),
     *              @OA\Property(property="stadium", type="string", example="Stadium 1"),
     *              @OA\Property(property="city", type="string", example="City 1"),
     *              @OA\Property(property="country", type="string", example="Country 1"),
     *              @OA\Property(property="coach", type="string", example="Coach 1"),
     *              @OA\Property(property="league", type="string", example="League 1"),
     *              @OA\Property(property="active", type="boolean", example="true"),
     *              @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Team not found.")
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
    public function update(Request $request, string $id)
    {
        return $this->teamService->update($request, $id);
    }

    /**
     * @OA\Delete(
     *     path="/api/teams/{id}",
     *     tags={"Teams"},
     *     summary="Deactivate or activate a team",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The team ID",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Team not found.")
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
    public function destroy(string $id)
    {
        return $this->teamService->destroy($id);
    }
}
