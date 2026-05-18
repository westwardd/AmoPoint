<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatsBasicAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $expectedUser = config('stats.user');
        $expectedPass = config('stats.pass');

        $user = $request->getUser();
        $pass = $request->getPassword();

        if (! is_string($user) || ! is_string($pass) || $user !== $expectedUser || $pass !== $expectedPass) {
            return response('Unauthorized', 401, [
                'WWW-Authenticate' => 'Basic realm="Stats"',
            ]);
        }

        return $next($request);
    }
}
