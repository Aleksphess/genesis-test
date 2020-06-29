<?php

declare(strict_types=1);

namespace tests\codeception\common\fixtures;

use api\modules\api\models\Article;
use yii\test\ActiveFixture;

class ArticleFixture extends ActiveFixture
{
    public $modelClass = Article::class;
}
