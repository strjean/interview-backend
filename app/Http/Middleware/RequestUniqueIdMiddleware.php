<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RequestUniqueIdMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $uuid = (string) Str::uuid();
        $request->headers->set('X-Request-ID', $uuid);

        return $next($request);
    }
}
