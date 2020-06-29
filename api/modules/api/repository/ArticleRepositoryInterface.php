<?php

declare(strict_types=1);

namespace api\modules\api\repository;

use api\modules\api\resources\Article;
use yii\data\DataProviderInterface;

interface ArticleRepositoryInterface
{
    public function findOneByAlias(string $alias): Article;

    public function findByParams(array $filterParams = [], array $sortParams = []): DataProviderInterface;

    public function createArticle(array $params): Article;

    public function save(Article $article): void;

    public function delete(string $alias): Article;

    public function update(Article $article, array $params): void;
}