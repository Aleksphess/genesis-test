<?php

declare(strict_types=1);

namespace api\modules\api\resources;

use  api\modules\api\models\Article as BaseArticle;

class Article extends BaseArticle
{
    public function fields()
    {
        return $this->attributes();
    }

    public function extraFields(): array
    {
        return [
            'category',
        ];
    }
}
