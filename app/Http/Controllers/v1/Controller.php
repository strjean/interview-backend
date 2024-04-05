<?php

namespace App\Http\Controllers\v1;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Useful when flat JSON is cached (faster response) instead of an Eloquent instance
     *
     * @param  string|null  $content
     * @param  int|null  $status
     * @return JsonResponse
     */
    protected function responseAsJson(?array $content = [], ?int $status = 200, array $headers = [], $options = JSON_UNESCAPED_UNICODE): JsonResponse
    {
        return response()->json($content, $status, $headers, $options);
    }
}
