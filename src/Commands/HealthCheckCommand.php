<?php

namespace Brightfish\HealthChecks\Commands;

use Illuminate\Console\Command;

class HealthCheckCommand extends Command
{
    /** @inheritdoc */
    public $signature = 'health:check';

    /** @inheritdoc */
    public $description = 'Run one or more configured health checks.';

    public function handle(): void
    {
        $this->comment('All done');
    }
}
