<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class APIVersion
 */
class APIVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards): mixed
    {
        // avoiding exceptions on notices (typically "undefined index" errors)
        error_reporting(E_ALL ^ E_NOTICE);

        config(['app.api.version' => $guards]);

        return $next($request);
    }
}
