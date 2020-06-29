<?php

declare(strict_types=1);

namespace api\modules\api\repository;

use api\modules\api\resources\Category;
use yii\data\DataProviderInterface;

interface CategoryRepositoryInterface
{
    public function findOneByAlias(string $alias): Category;

    public function findOneById(int $id): Category;

    public function findByParams(array $filterParams = [], array $sortParams = []): DataProviderInterface;

    public function createCategory(array $params): Category;

    public function save(Category $category): void;

    public function delete(string $alias): void;

    public function update(Category $category, array $params): void;
}