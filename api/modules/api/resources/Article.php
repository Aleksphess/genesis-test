<?php

declare(strict_types=1);

namespace api\modules\api\resources;

use  api\modules\api\models\Article as BaseArticle;

class Article extends BaseArticle
{
    public function extraFields(): array
    {
        return [
            'category',
        ];
    }
}
