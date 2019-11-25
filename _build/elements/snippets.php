<?php

return [
    'QuickApi' => [
        'file' => 'QuickApi',
        'description' => 'QuickApi snippet to check authentication/permissions and process the API call to the proper snippet endpoint.'
    ],
    'ApiHelloWorld' => [
        'file' => 'ApiHelloWorld',
        'description' => 'Args: $api (Api class), $method (HTTP), $body (Array), $path (Array), $params (Array query parms)'
    ],
    'ApiAuthorized' => [
        'file' => 'ApiAuthorized',
        'description' => 'Authorize any API calls: $api (QuickApi class), $authToken (X-API-Key if present), $hostname, $method (HTTP), $body (Array), $path (Array), $params (Array query parms)\nThis Snippet is called for every API call.'
    ]
];