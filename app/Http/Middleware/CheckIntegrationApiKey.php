<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIntegrationApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-Integration-Key') ?? $request->query('api_key');
        $validKey = env('INTEGRATION_API_KEY');

        if (!$apiKey || !$validKey || $apiKey !== $validKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: Invalid or missing integration API key'
            ], 401);
        }

        return $next($request);
    }
}
