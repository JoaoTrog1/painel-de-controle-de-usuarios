<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Unauthorized access. Please provide a valid API token.',
                'error' => 'Unauthenticated',
            ], 401);
        }
        
        return response()->json([
            'message' => 'Unauthorized access. Please log in first.',
            'error' => 'Unauthenticated',
        ], 401);
    }
}
