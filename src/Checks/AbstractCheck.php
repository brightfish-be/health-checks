<?php

namespace Brightfish\HealthChecks\Checks;

abstract class AbstractCheck
{
    /**
     * Whether an exception for this check should be reported.
     * @var bool
     */
    protected bool $reportable = true;

    /**
     * The (HTTP) code for the exceptions triggered by this check.
     * @var int
     */
    protected int $code = 500;

    /**
     * Run the check.
     * @return bool
     */
    abstract public function run(): bool;

    /**
     * Return the error message.
     * @return string
     */
    abstract public function getMessage(): string;

    /**
     * Can Laravel report exceptions for this check?
     * @return bool|null
     */
    public function shouldReport(): ?bool
    {
        return $this->reportable;
    }

    /**
     * Return the (HTTP) code for the error.
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }
}
