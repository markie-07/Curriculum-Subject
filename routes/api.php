<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (Stateless/Token-Based)
|--------------------------------------------------------------------------
|
| This file is reserved for stateless API routes that use token-based
| authentication (e.g., Sanctum tokens for mobile apps or external APIs).
|
| ⚠️ IMPORTANT: All application API routes are defined in web.php
| This provides better security with CSRF protection, session management,
| and cookie encryption for the Blade-based SPA architecture.
|
| Routes here are automatically prefixed with /api and use the 'api'
| middleware group (stateless, rate-limited, no CSRF protection).
|
*/

// Sanctum user endpoint for token-based authentication
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Future External API Routes
|--------------------------------------------------------------------------
|
| If you need to expose stateless API endpoints for:
| - Mobile applications
| - Third-party integrations
| - Webhook receivers
| - Public APIs
|
| Define them here with appropriate authentication and rate limiting.
|
| Example:
| Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
|     Route::get('/external/curriculums', [ExternalApiController::class, 'index']);
| });
|
*/