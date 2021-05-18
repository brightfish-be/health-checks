<?php

namespace Brightfish\HealthChecks\Services;

use Brightfish\HealthChecks\Checks\AbstractCheck;
use Brightfish\HealthChecks\Exceptions\BaseHealthException;
use Brightfish\HealthChecks\Exceptions\HealthException;
use Brightfish\HealthChecks\Exceptions\NonCheckException;

class HealthService
{
    /** @var string[] */
    protected array $checks;

    /** @var array */
    protected array $config;

    /**
     * HealthService constructor.
     * @param string[] $checks
     * @param array $config
     */
    public function __construct(array $checks, array $config = [])
    {
        $this->checks = $checks;

        $this->config = $config;
    }

    /**
     * Run all the configured checks.
     * @throws BaseHealthException
     */
    public function run(): bool
    {
        foreach ($this->checks as $check) {
            $checkInstance = new $check($this->config);

            if (!$checkInstance instanceof AbstractCheck) {
                throw new NonCheckException($check);
            }

            if (!$checkInstance->run()) {
                throw new HealthException($checkInstance);
            }
        }

        return true;
    }

    /**
     * Get a config value.
     * @return mixed
     */
    protected function getConfig(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    /**
     * Return all configured checks.
     * @return string[]
     */
    public function getChecks(): array
    {
        return $this->checks;
    }
}
