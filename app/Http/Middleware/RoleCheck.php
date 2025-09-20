<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleCheck
{
    /**
     * Handle an incoming request.
     * $roles bisa array atau single role id
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (!$user || !in_array($user->role_id, $roles)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Access restricted by role.'
            ], 403);
        }

        return $next($request);
    }
}
