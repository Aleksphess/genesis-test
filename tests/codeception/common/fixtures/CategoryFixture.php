<?php

declare(strict_types=1);

namespace tests\codeception\common\fixtures;

use api\modules\api\models\Category;
use yii\test\ActiveFixture;

class CategoryFixture extends ActiveFixture
{
    public $modelClass = Category::class;
}
