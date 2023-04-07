<?php

namespace Brightfish\HealthChecks\Services;

use Brightfish\HealthChecks\Checks\AbstractCheck;
use Brightfish\HealthChecks\Exceptions\BaseHealthException;
use Brightfish\HealthChecks\Exceptions\HealthException;
use Brightfish\HealthChecks\Exceptions\NonCheckException;
use Brightfish\HealthChecks\HealthConstants;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class HealthService
{
    /** @var string[] */
    protected array $checks;

    /** @var array */
    protected array $config;

    /** @var CacheInterface */
    protected CacheInterface $cache;

    /**
     * HealthService constructor.
     * @param string[] $checks
     * @param CacheInterface $cache
     * @param array $config
     */
    public function __construct(array $checks, CacheInterface $cache, array $config = [])
    {
        $this->checks = $checks;

        $this->cache = $cache;

        $this->config = $config;
    }

    /**
     * Run all the configured checks.
     * @throws BaseHealthException
     */
    public function run(): bool
    {
        foreach ($this->checks as $check) {
            $checkInstance = new $check($this->cache);

            if (! $checkInstance instanceof AbstractCheck) {
                throw new NonCheckException($check);
            }

            if (! $checkInstance->run()) {
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

    /**
     * @param string $key
     * @return string
     */
    public static function createCacheTimeKey(string $key): string
    {
        return HealthConstants::CACHE_TIME_KEY_PREFIX . $key;
    }

    /**
     * Store the time (of an artisan command or a matched route).
     * @see \Brightfish\HealthChecks\HealthServiceProvider::registerEventListeners()
     * @param string $key
     * @return bool
     * @throws InvalidArgumentException
     */
    public function setTime(string $key): bool
    {
        return $this->cache->set(static::createCacheTimeKey($key), strtotime('now'));
    }

    /**
     * Get the cached timestamp (of an artisan command or a matched route).
     * @param string $key
     * @return int|null
     * @throws InvalidArgumentException
     */
    public function getTime(string $key): ?int
    {
        return $this->cache->get(static::createCacheTimeKey($key));
    }
}
