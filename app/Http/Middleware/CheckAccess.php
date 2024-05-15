<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Check if the authenticated user has the superadmin role
        if (!auth()->user()->hasRole('superadmin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // If the user is authenticated and has the superadmin role, proceed with the request
        return $next($request);
    }
}
