<?php

namespace Brightfish\HealthChecks\Tests;

use Brightfish\HealthChecks\Exceptions\BaseHealthException;
use Brightfish\HealthChecks\Exceptions\NonCheckException;
use Brightfish\HealthChecks\Services\HealthService;
use Brightfish\HealthChecks\Tests\Mocks\MockCommand;
use Brightfish\HealthChecks\Tests\TestChecks\InValidCheck;
use Brightfish\HealthChecks\Tests\TestChecks\NonCheck;
use Brightfish\HealthChecks\Tests\TestChecks\ValidCheck;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Contracts\Console\Kernel;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class FeatureTest extends TestCase
{
    /** @test */
    public function non_check_throws_error()
    {
        $this->expectException(NonCheckException::class);

        $this->app->config->set('health.checks', [
            NonCheck::class,
        ]);

        $this->app[HealthService::class]->run();
    }

    /** @test */
    public function single_invalid_check_throws_error()
    {
        $this->expectException(BaseHealthException::class);

        $this->app->config->set('health.checks', [
            InValidCheck::class,
        ]);

        $this->app[HealthService::class]->run();
    }

    /** @test */
    public function single_valid_check_returns_true()
    {
        $this->app->config->set('health.checks', [
            ValidCheck::class,
        ]);

        $this->assertTrue(
            $this->app[HealthService::class]->run()
        );
    }

    /** @test */
    public function multiple_checks_throw_error()
    {
        $this->expectException(BaseHealthException::class);

        $this->app->config->set('health.checks', [
            ValidCheck::class,
            InValidCheck::class,
        ]);

        $this->app[HealthService::class]->run();
    }

    /** @test */
    public function cmds_in_namespace_should_be_logged()
    {
        // Change the namespace to the mocked commands one.
        $this->app['config']->set('health.artisan.cmd_namespace', 'Brightfish\HealthChecks\Tests\Mocks');

        // From Laravel 10 Console commands aren't triggered during testing, so we trigger the event manually
        // and we only test the listener in the HealthServiceProvider, instead of the whole feature.

        $input = new StringInput('');

        $output = new ConsoleOutput();

        event(new CommandFinished('health:mock', $input, $output, 0));

        //$artisan = $this->app->make(Kernel::class);

        //$artisan->call(MockCommand::class);

        $this->assertIsInt(
            $this->app[HealthService::class]->getTime('health:mock')
        );
    }

    /** @test */
    public function default_cmds_should_not_be_logged()
    {
        $this->app->make(Kernel::class)->call('list');

        $this->assertTrue(
            is_null($this->app[HealthService::class]->getTime('list'))
        );
    }
}
