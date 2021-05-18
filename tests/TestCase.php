<?php

namespace Brightfish\HealthChecks\Tests;

use Brightfish\HealthChecks\HealthServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            HealthServiceProvider::class,
        ];
    }
}
