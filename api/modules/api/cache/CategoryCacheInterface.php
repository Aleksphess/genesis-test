<?php

declare(strict_types=1);

namespace api\modules\api\cache;

use api\modules\api\resources\Category;

interface CategoryCacheInterface
{
    public function setCategory(Category $category, ?int $ttl = null): void;

    public function getCategory(string $alias): Category;
}
