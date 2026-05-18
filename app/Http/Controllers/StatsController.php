<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Contracts\View\View;

class StatsController extends Controller
{
    public function index(): View
    {
        $since = now()->subDay();
        $visits = Visit::query()
            ->where('visited_at', '>=', $since)
            ->orderBy('visited_at')
            ->get();

        $hourBuckets = [];
        foreach ($visits as $visit) {
            $hour = $visit->visited_at->format('Y-m-d H:00');
            $hourBuckets[$hour] ??= [];
            $hourBuckets[$hour][$visit->ip] = true;
        }

        ksort($hourBuckets);
        $hourLabels = array_keys($hourBuckets);
        $hourCounts = array_map(static fn (array $ips) => count($ips), $hourBuckets);

        $cityBuckets = [];
        foreach ($visits as $visit) {
            $city = $visit->city ?: 'Unknown';
            $cityBuckets[$city] ??= [];
            $cityBuckets[$city][$visit->ip] = true;
        }

        $cityCountsMap = [];
        foreach ($cityBuckets as $city => $ips) {
            $cityCountsMap[$city] = count($ips);
        }

        arsort($cityCountsMap);
        $cityLabels = array_keys($cityCountsMap);
        $cityCounts = array_values($cityCountsMap);

        return view('stats', [
            'since' => $since,
            'hourLabels' => $hourLabels,
            'hourCounts' => $hourCounts,
            'cityLabels' => $cityLabels,
            'cityCounts' => $cityCounts,
        ]);
    }
}
