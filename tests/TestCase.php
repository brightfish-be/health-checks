<?php

namespace Brightfish\HealthChecks\Tests;

use Brightfish\HealthChecks\HealthServiceProvider;
use Brightfish\HealthChecks\Tests\Mocks\MockCommand;
use Illuminate\Console\Application as Artisan;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        Artisan::starting(function ($artisan) {
            $artisan->resolveCommands([MockCommand::class]);
        });

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
