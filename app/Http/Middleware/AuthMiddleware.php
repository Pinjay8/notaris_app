<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Ambil token dari .env
        $staticToken = env('API_TOKEN');

        // Ambil header Authorization
        $authHeader = $request->header('Authorization');

        if (!$authHeader || $authHeader !== "Bearer $staticToken") {
            return response()->json([
                'message' => 'Unauthorized. Invalid or missing token.'
            ], 401);
        }

        return $next($request);
    }
}
