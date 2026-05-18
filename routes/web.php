<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stats', [\App\Http\Controllers\StatsController::class, 'index'])
    ->middleware('stats.auth');
