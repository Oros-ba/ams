<?php

return [
    'routes' => [
        [
            'name' => 'api#readAll',
            'url' => '/api/subjects',
            'verb' => 'GET',
            'requirements' => [
                '_controller' => 'OCA\\AMS\\Controller\\ApiController::readAll'
            ]
        ],
        // Add other routes here
    ]
];
