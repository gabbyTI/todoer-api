<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the api key passed in the header is authorized

        $apiKey = $request->header('X-API-Key');

        if (!in_array($apiKey, explode(',', config('app.api_keys')))) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
        // }

        return $next($request);
    }
}
