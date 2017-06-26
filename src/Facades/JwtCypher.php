<?php

namespace Iw\Api\Facades;

use Illuminate\Support\Facades\Facade;
use \Firebase\JWT\JWT;

class JwtCypher extends Facade
{
    public static function encode(array $token)
    {
        return JWT::encode($token, self::secret(), 'HS256');
    }

    public static function decode($jwt)
    {
        return JWT::decode($jwt, self::secret(), array('HS256'));
    }

    protected static function secret()
    {
        return config('iw_api.jwt.secret');
    }
}
