<?php

// config for WaAPI/WaAPI
// return [
//     'api_token' => env('WAAPI_API_TOKEN'),
//     'instance_id' => env('WAAPI_INSTANCE_ID'),
// ];

return [
    'base_url' => env('WAAPI_BASE_URL', 'https://waapi.app/api/v1'),
    'instance_id' => env('WAAPI_INSTANCE_ID'),
    'api_token' => env('WAAPI_API_TOKEN'),
];

