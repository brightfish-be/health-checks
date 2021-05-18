<?php

namespace Brightfish\HealthChecks\Tests\TestChecks;

use Brightfish\HealthChecks\Checks\AbstractCheck;

class ValidCheck extends AbstractCheck
{
    public function run(): bool
    {
        return true;
    }

    public function getMessage(): string
    {
        return 'Error';
    }
}
