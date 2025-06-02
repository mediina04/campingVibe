<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->hasRole('admin')) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Admins only.'], 403);
            }

            abort(403, 'Unauthorized');
        }

        return $next($request);
    }

}

