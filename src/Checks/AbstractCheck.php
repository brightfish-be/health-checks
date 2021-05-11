<?php

namespace App\Health;

abstract class AbstractCheck
{
    /**
     * Run the health check.
     * @return bool
     */
    abstract public function check(): bool;

    /**
     * Return the error message.
     * @return string
     */
    abstract public function getMessage(): string;
}
