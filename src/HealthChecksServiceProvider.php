<?php

namespace Brightfish\HealthChecks;

use Brightfish\HealthChecks\Commands\HealthCheckCommand;

class HealthChecksServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('health-checks')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_health-checks_table')
            ->hasCommand(HealthCheckCommand::class);
    }
}
