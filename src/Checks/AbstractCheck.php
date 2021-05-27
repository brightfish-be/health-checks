<?php

namespace Brightfish\HealthChecks\Checks;

use Brightfish\HealthChecks\Services\HealthService;
use Carbon\Carbon;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

abstract class AbstractCheck
{
    /** @var string */
    protected string $message = '';

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
     * Default cache utility.
     * @var CacheInterface
     */
    protected CacheInterface $cache;

    /**
     * Run the check.
     * @return bool
     * @throws InvalidArgumentException
     */
    abstract public function run(): bool;

    /**
     * Return the error message.
     * @param string $msg
     * @return void
     */
    public function setMessage(string $msg): void
    {
        $this->message = $msg;
    }

    /**
     * Return the error message.
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * AbstractCheck constructor.
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

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

    /**
     * Get the cache time of an artisan command.
     * @param string $key
     * @return int|null
     * @throws InvalidArgumentException
     */
    protected function getTime(string $key): ?int
    {
        return $this->cache->get(HealthService::createCacheTimeKey($key));
    }

    /**
     * Return the difference between now and the last recorded timestamp for the given key.
     * @param string $key
     * @return int|null
     * @throws InvalidArgumentException
     */
    protected function diffFromNow(string $key): ?int
    {
        $time = $this->getTime($key);

        return !is_null($time) ? strtotime('now') - $time : $time;
    }

    /**
     * Format a readable time string from the given seconds.
     * @param int $seconds
     * @param string $format
     * @return string
     */
    protected function diffForHumans(int $seconds, string $format = 'long'): string
    {
        $diff = (new Carbon())->addSeconds($seconds);

        return $format === 'long' ? $diff->longAbsoluteDiffForHumans() : $diff->shortAbsoluteDiffForHumans();
    }
}
