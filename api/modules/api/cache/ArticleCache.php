<?php

declare(strict_types=1);

namespace api\modules\api\cache;

use api\modules\api\exceptions\NotFoundArticleException;
use api\modules\api\resources\Article;
use yii\caching\Cache;
use yii\caching\CacheInterface;

class ArticleCache implements ArticleCacheInterface
{
    private const TTL_HOUR = 3600;

    private CacheInterface $cache;

    private int $defaultTtl;

    private const CACHE_PATTERN = 'article_%s';

    public function __construct(Cache $cache, ?int $defaultTtl = null)
    {
        $this->cache = $cache;
        $this->defaultTtl = $defaultTtl ?? self::TTL_HOUR;
    }

    public function setArticle(Article $article, ?int $ttl = null): void
    {
        $ttl = $ttl ?? $this->defaultTtl;
        $this->cache->set($this->buildKey($article->getAlias()), $article, $ttl);
    }

    public function getArticle(string $alias): Article
    {
        $article = $this->cache->get($this->buildKey($alias));
        if (!$article instanceof Article) {
            throw new NotFoundArticleException(\sprintf('Not found article by alias: %s', $alias));
        }

        return $article;
    }

    private function buildKey(string $alias): string
    {
        return \sprintf(self::CACHE_PATTERN, $alias);
    }
}
