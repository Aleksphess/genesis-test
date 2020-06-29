<?php

declare(strict_types=1);

namespace api\modules\api\cache;

use api\modules\api\exceptions\NotFoundCategoryException;
use api\modules\api\resources\Category;
use yii\caching\Cache;
use yii\caching\CacheInterface;

class CategoryCache implements CategoryCacheInterface
{
    private const TTL_HOUR = 3600;

    private CacheInterface $cache;

    private int $defaultTtl;

    private const CACHE_PATTERN = 'category_%s';

    public function __construct(Cache $cache, ?int $defaultTtl = null)
    {
        $this->cache = $cache;
        $this->defaultTtl = $defaultTtl ?? self::TTL_HOUR;
    }

    public function setCategory(Category $category, ?int $ttl = null): void
    {
        $ttl = $ttl ?? $this->defaultTtl;
        $this->cache->set($this->buildKey($category->getAlias()), $category, $ttl);
    }

    public function getCategory(string $alias): Category
    {
        $category = $this->cache->get($this->buildKey($alias));
        if (!$category instanceof Category) {
            throw new NotFoundCategoryException(\sprintf('Not found category by alias: %s', $alias));
        }

        return $category;
    }

    private function buildKey(string $alias): string
    {
        return \sprintf(self::CACHE_PATTERN, $alias);
    }
}
