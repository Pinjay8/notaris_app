<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFullAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (
            !session('access_all_menu')
            // ||
            // now()->greaterThan(session('access_expires_at'))
        ) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}
