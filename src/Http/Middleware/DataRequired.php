<?php

namespace Iw\Api\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Closure;
use Iw\Api\Transformers\ErrorTransformer;

class DataRequired
{
    use \Iw\Api\Traits\Http\JsonResponders;

    public function __construct()
    {
    }

    public function handle($request, Closure $next, $guard = null)
    {
        if (!is_array($request["data"])) {
            return response()->json($this->jsonError(400), 400);
        }
        return $next($request);
    }
}
