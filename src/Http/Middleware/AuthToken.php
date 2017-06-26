<?php

namespace Iw\Api\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Iw\Api\Transformers\ErrorTransformer;

class AuthToken
{
    use \Iw\Api\Traits\Http\JsonResponders;

    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        $api_key = config('iw_api.token');
        $header = explode(" ", $request->header("Authorization"));
        $token = end($header);
        if ((!empty($api_key) && !empty($token) && $api_key != $token) || (empty($api_key) || empty($token))) {
            return response()->json($this->jsonError(403), 403);
        }

        return $next($request);
    }
}
