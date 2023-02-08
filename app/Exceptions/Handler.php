<?php

namespace App\Exceptions;

use ApplicationInsights\Telemetry_Client;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * @param $request
     * @param  AuthenticationException  $exception
     * @return JsonResponse|Response
     */
    protected function unauthenticated($request, AuthenticationException $exception): JsonResponse|Response
    {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
}
