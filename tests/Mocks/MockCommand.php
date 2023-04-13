<?php

namespace Brightfish\HealthChecks\Tests\Mocks;

use Brightfish\HealthChecks\Services\HealthService;
use Illuminate\Console\Command;

class MockCommand extends Command
{
    /** @inheritdoc */
    public $signature = 'health:mock';

    /** @inheritdoc */
    public $description = 'Mocking';

    /**
     * Run the checks.
     * @param HealthService $healthService
     * @return int
     */
    public function handle(HealthService $healthService): int
    {
        return 0;
    }
}
