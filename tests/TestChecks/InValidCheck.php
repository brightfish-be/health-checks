<?php

namespace Brightfish\HealthChecks\Tests\TestChecks;

use Brightfish\HealthChecks\Checks\AbstractCheck;

class InValidCheck extends AbstractCheck
{
    public function run(): bool
    {
        return false;
    }

    public function getMessage(): string
    {
        return 'Error';
    }
}
