<?php

declare(strict_types=1);

namespace api\modules\api\services;

use api\modules\api\resources\Article;
use yii\data\DataProviderInterface;

interface ArticleServiceInterface
{
    public function createArticle(array $params): Article;

    public function updateArticle(string $alias, array $params): Article;

    public function deleteArticle(string $alias): void;

    public function findArticle(string $alias): Article;

    public function findAllByParams(array $params): DataProviderInterface;
}
