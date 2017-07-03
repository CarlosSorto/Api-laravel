<?php

return [
  'jwt' => [
    'secret' => env('IW_API_JWT_SECRET', 'supersecret'),
    'issuer' => env('IW_API_JWT_ISSUER', 'iw'),
    'audience' => env('IW_API_JWT_AUDIENCE', 'Any'),
  ],
  'token' => env('IW_API_TOKEN', 'supersecret'),
  'url' => env('IW_API_URL', 'http://localhost:9000'),
  'asset_url' => env('IW_API_URL', 'http://localhost:9000'),
];
