<?php

namespace Brightfish\HealthChecks\Http\Controllers;

use Brightfish\HealthChecks\Exceptions\BaseHealthException;
use Brightfish\HealthChecks\Services\HealthService;
use Laravel\Lumen\Routing\Controller;

class HealthLumenController extends Controller
{
    /**
     * Run the health checks.
     * @throws BaseHealthException
     */
    public function __invoke(HealthService $healthService)
    {
        $healthService->run();
    }
}
