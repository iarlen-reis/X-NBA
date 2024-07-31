<?php

use App\Http\Controllers\Api\HelloWord;
use Illuminate\Support\Facades\Route;

// hello world route for testing swagger
Route::get('/hello', [HelloWord::class, 'index']);
