<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Joke;
use Illuminate\Http\JsonResponse;

class JokeController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Joke::query()->latest()->get()
        );
    }
}
