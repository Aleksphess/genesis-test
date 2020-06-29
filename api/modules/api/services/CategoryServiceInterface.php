<?php

declare(strict_types=1);

namespace api\modules\api\services;

use api\modules\api\resources\Category;
use yii\data\DataProviderInterface;

interface CategoryServiceInterface
{
    public function createCategory(array $params): Category;

    public function updateCategory(string $alias, array $params): Category;

    public function deleteCategory(string $alias): void;

    public function findCategory(string $alias): Category;

    public function findAllByParams(array $params): DataProviderInterface;
}
