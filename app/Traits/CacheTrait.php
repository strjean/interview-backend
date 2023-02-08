<?php

namespace App\Traits;

use DateInterval;
use DateTime;
use DateTimeInterface;
use Illuminate\Support\Facades\Cache;

trait CacheTrait
{
    /**
     * Specify the default amount of time to cache an item.
     *
     * @var int|DateTime
     */
    public int|DateTime $defaultCacheTTL = 3600; // cache time, in seconds

    /**
     * Manual caching: get an item.
     * If the item does not exist in the cache, null will be returned.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    protected function cacheGet(string $key, mixed $default = null): mixed
    {
        return Cache::get($key, $default);
    }

    /**
     * Manual caching: check if an item exists.
     * If the item does not exist in the cache, null will be returned.
     *
     * @param  string  $key
     * @return bool
     */
    protected function cacheHas(string $key): bool
    {
        return Cache::has($key);
    }

    /**
     * Manual caching: add a new item.
     * If the item does not exist in the cache, null will be returned.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  DateInterval|DateTimeInterface|int|null  $ttl
     * @return bool
     */
    protected function cacheSet(string $key, mixed $value, DateInterval|DateTimeInterface|int $ttl = null): bool
    {
        return Cache::put($key, $value, $ttl ?: $this->defaultCacheTTL);
    }
}
