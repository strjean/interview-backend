<?php

namespace App\Http\Middleware;

use BeyondCode\ServerTiming\Facades\ServerTiming;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate extends Middleware
{
    public function __construct(Auth $auth)
    {
        ServerTiming::start('Auth-Middleware');
        parent::__construct($auth);
        try {
            $user = auth()->userOrFail();
            $payload = auth()->payload()->toArray();
            $access = $payload['access'] ?? [];
            $user_is_active = $user->is_active ?? false;

            if ((! in_array('FP_ACCESS_TO_PLATFORM', $access) and ! in_array('PP_ACCESS_TO_PLATFORM', $access)) && $user) {
                auth()->logout();
            } elseif (! $user_is_active) {
                auth()->logout();
            }
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
        ServerTiming::stop('Auth-Middleware');
    }
}
