<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class GzipEncodeResponse
{
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        $compression_enabled = Config::get('app.gzip_compression', true);
        if (
            $compression_enabled
            && in_array('gzip', $request->getEncodings())
            && function_exists('gzencode')
        ) {
            $response->setContent(gzencode($response->getContent(), 9));
            $response->headers->add(['Content-Encoding' => 'gzip']);
        }

        return $response;
    }
}
