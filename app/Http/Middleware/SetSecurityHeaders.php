<?php

namespace App\Http\Middleware;

use Closure;

class SetSecurityHeaders
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('X-Content-Type-Options', 'nosniff')
            ->header('X-Frame-Options', 'DENY')
            ->header('X-XSS-Protection', '1; mode=block')
            ->header('Content-Security-Policy', "default-src 'self'");
    }
} 