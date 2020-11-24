<?php

return [
    'QuickApiRoute' => [
        'file' => 'QuickApiRoute',
        'description' => 'Based on the "API Path Root (quickapi.path_root)" property, this will re-format requests to the specified root path and send them to the "quickapi-process" resource.',
        'events' => [
            'OnMODXInit' => [],
        ],
    ]
];