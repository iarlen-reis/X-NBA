<?php

use App\Http\Controllers\Api\AveragesController;
use App\Http\Controllers\Api\MatchesController;
use App\Http\Controllers\Api\MatchesTeamController;
use App\Http\Controllers\Api\PlayersController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Api\TeamsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('teams', TeamsController::class);
Route::apiResource('players', PlayersController::class);
Route::apiResource('averages', AveragesController::class);
Route::apiResource('matches', MatchesController::class);

Route::apiResource('matche-teams', MatchesTeamController::class);
Route::apiResource('stats', StatsController::class);
