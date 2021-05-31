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

    /** @inheritDoc */
    protected function defineEnvironment($app)
    {
        $app['config']->set('cache.default', 'array');
    }

    /** @inheritDoc */
    protected function getPackageProviders($app)
    {
        return [
            HealthServiceProvider::class,
        ];
    }
}
