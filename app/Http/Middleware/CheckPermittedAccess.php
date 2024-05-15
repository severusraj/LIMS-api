<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermittedAccess
{
    public function handle(Request $request, Closure $next, ...$access)
    {
        $user = $request->user();
        if (!$user || !array_intersect($user->access, $access)) {
            return abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
