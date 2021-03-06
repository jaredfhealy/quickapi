<?php

return [
    'QuickApi' => [
        'file' => 'QuickApi',
        'description' => 'QuickApi snippet to check authentication/permissions and process the API call to the proper snippet endpoint.'
    ],
    'ApiHelloWorld' => [
        'file' => 'ApiHelloWorld',
        'description' => 'Args: $quickapi (QuickApi class instance), $method (HTTP), $body (Array), $path (Array), $params (Array query parms)'
    ],
    'ApiAuthorized' => [
        'file' => 'ApiAuthorized',
        'description' => 'Authorize any API calls: $quickapi (QuickApi class instance), $authToken (X-API-Key if present), $hostname, $method (HTTP), $body (Array), $path (Array), $params (Array query parms)'
    ]
];