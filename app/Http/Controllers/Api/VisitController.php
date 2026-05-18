<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VisitController extends Controller
{
    public function preflight(): Response
    {
        return $this->cors(response()->noContent());
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $request->json()->all();

        $ip = isset($payload['ip']) && is_string($payload['ip']) ? $payload['ip'] : $request->ip();
        $city = isset($payload['city']) && is_string($payload['city']) ? $payload['city'] : null;
        $device = isset($payload['device']) && is_string($payload['device']) ? $payload['device'] : null;

        Visit::create([
            'ip' => $ip ?? 'unknown',
            'city' => $city,
            'device' => $device,
            'user_agent' => substr((string) $request->userAgent(), 0, 512),
            'visited_at' => now(),
        ]);

        return $this->cors(response()->json(['ok' => true]));
    }

    private function cors(Response|JsonResponse $response): Response|JsonResponse
    {
        return $response
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
}
