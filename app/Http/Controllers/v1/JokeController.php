<?php

namespace App\Http\Controllers\v1;

use App\Traits\CacheTrait;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class JokeController extends Controller
{
    use CacheTrait;

    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function get(Request $request): JsonResponse
    {
        $rules = [
            'lang' => 'nullable|in:fr,en',
            'category' => 'nullable|in:any,programming,misc,dark,pun,spooky,christmas'
        ];
    
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        error_log($request->query('lang') ?? 'en');

        $langParams = ['lang' => $request->query('lang') ?? 'en'];
        $category = $request->query('category') ?? 'any';

        $response = $this->httpClient->request('GET', 'https://v2.jokeapi.dev/joke/'.$category, ['query' => $langParams]);

        if ($response->getStatusCode() === 200) {
            $data = json_decode ($response->getBody());

            if ($data->error === false) {
                return $this->responseAsJson([
                    'setup' => $data->setup,
                    'delivery' => $data->delivery,
                ]);
            } else {
                return $this->responseAsJson([
                    'error' => $data->message
                ], 404);
            }
        } else {
            return $this->responseAsJson([
                'error' => 'INTERNAL API ERROR'
            ], $response->getStatusCode());
        }

    }
}
