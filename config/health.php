<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application health checks
    |--------------------------------------------------------------------------
    |
    | All checks listed here will be run in this order by the HealthService.
    | The array expects fully-qualified classnames of health check classes
    | inheriting the package's AbstractCheck class.
    |
    */

    'checks' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    |
    | This configures the health endpoints, it can be left falsy to disable
    | HTTP health checking altogether.
    |
    */

    'router' => [
        'uri' => '/health',

        'middleware' => [
            //
        ],
    ]
];
