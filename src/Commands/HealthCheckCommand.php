<?php

namespace Brightfish\HealthChecks\Commands;

use Brightfish\HealthChecks\Exceptions\BaseHealthException;
use Brightfish\HealthChecks\Services\HealthService;
use Illuminate\Console\Command;

class HealthCheckCommand extends Command
{
    /** @inheritdoc */
    public $signature = 'health:check';

    /** @inheritdoc */
    public $description = 'Run one or more configured health checks.';

    /**
     * Run the checks.
     * @throws BaseHealthException
     */
    public function handle(HealthService $healthService): void
    {
        $healthService->run();
    }
}
