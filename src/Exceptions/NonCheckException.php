<?php

namespace Brightfish\HealthChecks\Exceptions;

use Brightfish\HealthChecks\Checks\AbstractCheck;

class NonCheckException extends BaseHealthException
{
    /**
     * NonCheckException constructor.
     * @param string $check
     */
    public function __construct(string $check)
    {
        parent::__construct(
            "$check does not inherit from " . AbstractCheck::class
        );
    }
}
