<?php

use App\Http\Controllers\Api\HelloWord;
use App\Http\Controllers\Api\PlayersController;
use App\Http\Controllers\Api\TeamsController;
use Illuminate\Support\Facades\Route;

// hello world route for testing swagger
Route::get('/hello', [HelloWord::class, 'index']);

Route::apiResource('teams', TeamsController::class);
Route::apiResource('players', PlayersController::class);
