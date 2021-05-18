<?php

namespace Brightfish\HealthChecks\Exceptions;

use Brightfish\HealthChecks\Checks\AbstractCheck;
use Symfony\Component\HttpFoundation\Response;

class HealthException extends BaseHealthException
{
    protected AbstractCheck $check;

    /**
     * HealthException constructor.
     * @param AbstractCheck $check
     */
    public function __construct(AbstractCheck $check)
    {
        parent::__construct($check->getMessage(), $check->getCode());

        $this->check = $check;
    }

    /**
     * Report the exception.
     * @return bool|null
     */
    public function report(): ?bool
    {
        return $this->check->shouldReport();
    }

    /**
     * Render the exception into an HTTP response.
     * @return Response
     */
    public function render(): Response
    {
        return new Response($this->check->getMessage(), $this->check->getCode(), ['Content-Type' => 'text/plain']);
    }
}
