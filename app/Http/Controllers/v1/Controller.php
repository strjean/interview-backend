<?php

namespace App\Http\Controllers\v1;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Useful when flat JSON is cached (faster response) instead of an Eloquent instance
     *
     * @param  string|null  $content
     * @param  int|null  $status
     * @return Response|Application|ResponseFactory
     */
    protected function responseAsJson(?string $content = '', ?int $status = 200): Response|Application|ResponseFactory
    {
        return response(
            content: $content,
            status: $status,
            headers: ['Content-Type' => 'application/json'],
        );
    }
}
