<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HelloWord extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/hello",
     *     tags={"Hello"},
     *     summary="Returns a hello message",
     *     description="Returns a hello message",
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Hello World!")
     *         )
     *     )
     * )
     */
    function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Hello World!',
        ]);
    }
}
