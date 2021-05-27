<?php

namespace Brightfish\HealthChecks;

final class HealthConstants
{
    /** @var string */
    public const CONFIG_PATH = __DIR__ . '/../config/health.php';

    /** @var string */
    public const DEFAULT_ROUTE_URI = '/health';

    /** @var string */
    public const CACHE_TIME_KEY_PREFIX = 'health-time:';
}
