<?php

use App\Http\Controllers\Api\AveragesController;
use App\Http\Controllers\Api\PlayersController;
use App\Http\Controllers\Api\TeamsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('teams', TeamsController::class);
Route::apiResource('players', PlayersController::class);
Route::apiResource('averages', AveragesController::class);
