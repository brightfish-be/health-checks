<?php

namespace Brightfish\HealthChecks\Commands;

use Illuminate\Console\Command;

class HealthCheckCommand extends Command
{
    public $signature = 'health:check';

    public $description = 'Run one or more configured health checks.';

    public function handle()
    {
        $this->comment('All done');
    }
}
