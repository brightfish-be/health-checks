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
    | HTTP router configuration
    |--------------------------------------------------------------------------
    |
    | This configures the health endpoint, its middleware, as well as
    | the recording of the timestamp of each matched routes. If the `path`
    | property is left falsy, no routes will be created.
    |
    */

    'router' => [
        'path' => '/health',

        'middleware' => [
            //
        ],

        'log_time' => false
    ],

    /*
    |--------------------------------------------------------------------------
    | Artisan configuration
    |--------------------------------------------------------------------------
    |
    | Enable the recording of the time whenever an artisan command in the
    | given namespace finishes running.
    |
    */

    'artisan' => [
        'cmd_namespace' => 'App\Console\Commands',

        'log_time' => true,
    ],

];
