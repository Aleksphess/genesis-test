<?php

declare(strict_types=1);

namespace api\modules\api\cache;

use api\modules\api\resources\Article;

interface ArticleCacheInterface
{
    public function setArticle(Article $category, ?int $ttl = null): void;

    public function getArticle(string $alias): Article;
}
