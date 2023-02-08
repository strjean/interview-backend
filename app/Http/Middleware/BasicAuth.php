<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Opcodes\LogViewer\Facades\LogViewer;

class BasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $AUTH_USER = 'vouslesdevs';
        $AUTH_PASS = 'DungeonMaster666';
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        $has_supplied_credentials = ! (empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
        $is_not_authenticated = (
            ! $has_supplied_credentials ||
            $_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
            $_SERVER['PHP_AUTH_PW'] != $AUTH_PASS
        );
        if ($is_not_authenticated) {
            header('HTTP/1.1 401 Authorization Required');
            header('WWW-Authenticate: Basic realm="Access denied"');
            exit;
        }

        // limit access to log viewer
        LogViewer::auth(function ($request) {
            return $request->user()
                && in_array($request->user()->email, [
                    'c.noterdaem+prod@soilcapital.com',
                    'c.noterdaem+test2@soilcapital.com',
                    'f.desmet+agro@soilcapital.com',
                    'a.doat+agro@soilcapital.com',
                    'r.lacroix+agro@soilcapital.com',
                    'q.luc+agro@soilcapital.com',
                    'a.zochowski+agronomist@soilcapital.com',
                ]);
        });

        return $next($request);
    }
}
