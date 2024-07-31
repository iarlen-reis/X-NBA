<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 * title="X-NBA Documentation",
 * description="This is the API documentation for the X-NBA API.",
 * version="1.0.0",
 * )
 * @OA\SecurityScheme(
 * type="http",
 * securityScheme="bearerAuth",
 * scheme="bearer",
 * bearerFormat="JWT"
 * )
 */
abstract class Controller
{
    //
}
