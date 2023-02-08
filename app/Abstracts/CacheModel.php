<?php

namespace App\Abstracts;

use App\Traits\CacheTrait;
use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;
use Chelout\RelationshipEvents\Traits\HasRelationshipObservables;
use DateTime;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * Cache Eloquent Model
 * with Eloquent Query Cache: https://leqc.renoki.org/cache-tags/query-caching
 * and CacheTrait
 */
abstract class CacheModel extends BaseModel
{
    use HasBelongsToManyEvents, HasRelationshipObservables, QueryCacheable, CacheTrait;

    /**
     * Specify the amount of time to cache queries.
     * Do not specify or set it to null to disable caching.
     *
     * @var int|DateTime
     */
    public int|DateTime $cacheFor = 3600; // cache time, in seconds

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static bool $flushCacheOnUpdate = true;

    /**
     * The tags for the query cache. Can be useful
     * if flushing cache for specific tags only.
     *
     * @return array|null
     */
    protected function cacheTagsValue(): ?array
    {
        return [$this->table];
    }

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @return string
     */
    protected function cachePrefixValue(): string
    {
        return $this->table.'_';
    }
}
