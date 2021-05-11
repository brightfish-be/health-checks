<?php

namespace Brightfish\HealthChecks;

use Illuminate\Support\ServiceProvider;

class HealthServiceProvider extends ServiceProvider
{
    /**
     * Checks to perform.
     * @var string[]
     */
    protected array $checks = [
        //
    ];
}
