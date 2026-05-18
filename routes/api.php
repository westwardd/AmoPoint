<?php

use App\Http\Controllers\Api\JokeController;
use App\Http\Controllers\Api\VisitController;
use Illuminate\Support\Facades\Route;

Route::get('/jokes', [JokeController::class, 'index']);

Route::options('/track', [VisitController::class, 'preflight']);
Route::post('/track', [VisitController::class, 'store']);
