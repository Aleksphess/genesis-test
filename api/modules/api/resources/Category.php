<?php

declare(strict_types=1);

namespace api\modules\api\resources;

use api\modules\api\models\Category as BaseCategory;

class Category extends BaseCategory
{
    public function fields(): array
    {
        return $this->attributes();
    }

    public function extraFields()
    {
        return [
            'articles',
        ];
    }
}
