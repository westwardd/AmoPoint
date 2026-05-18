<?php

namespace App\Console\Commands;

use App\Models\Joke;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchJokeCommand extends Command
{
    protected $signature = 'jokes:fetch';
    protected $description = 'Fetch a random joke from the public API and store it';

    public function handle(): int
    {
        $response = Http::timeout(10)->get('https://official-joke-api.appspot.com/random_joke');

        if (! $response->successful()) {
            $this->error('Failed to fetch joke: '.$response->status());
            return self::FAILURE;
        }

        $payload = $response->json();

        if (! is_array($payload)) {
            $this->error('Unexpected payload');
            return self::FAILURE;
        }

        Joke::create([
            'external_id' => $payload['id'] ?? null,
            'type' => $payload['type'] ?? null,
            'setup' => $payload['setup'] ?? null,
            'punchline' => $payload['punchline'] ?? null,
            'raw' => $payload,
        ]);

        $this->info('Joke stored');

        return self::SUCCESS;
    }
}
