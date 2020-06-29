<?php

declare(strict_types=1);

namespace api\modules\api\repository;

use api\modules\api\exceptions\NotFoundCategoryException;
use api\modules\api\resources\Category;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class CategoryRepository extends ActiveQuery implements CategoryRepositoryInterface
{
    public function createCategory(array $params): Category
    {
        /**
         * @var Category $category
         */
        $category = new $this->modelClass;
        $category->load($params, '');
        $category->setCreateAt();
        $category->changeUpdateAt();
        $category->setNewStatus();

        return $category;
    }

    public function findOneByAlias(string $alias): Category
    {
        $category = $this->where(['alias' => $alias])->one();

        if (null === $category) {
            throw new NotFoundCategoryException(\sprintf('Category not found by alias %s', $alias));
        }

        return $category;
    }

    public function findOneById(int $id): Category
    {
        $category = $this->where(['id' => $id])->one();

        if (null === $category) {
            throw new NotFoundCategoryException(\sprintf('Category not found by id %s', $id));
        }

        return $category;
    }

    public function findByParams(array $filterParams = [], array $sortParams = []): DataProviderInterface
    {
        $this->andFilterWhere(
            [
                'status' => $filterParams['status'] ?? null,
            ]
        );

        $this->orderBy(
            [
                'created_at' => $sortParams['created_at'] ?? null,
                'updated_at' => $sortParams['updated_at'] ?? null,
            ]
        );

        return new ActiveDataProvider([
            'query' => $this
        ]);
    }

    public function save(Category $category): void
    {
        $category->save();
    }

    public function delete(string $alias): void
    {
        $category = $this->where(['alias' => $alias])->one();

        if (null === $category) {
            throw new NotFoundCategoryException(\sprintf('Category not found by alias %s', $alias));
        }

        $category->delete();
    }

    public function update(Category $category, array $params): void
    {
        $category->load($params, '');
        $category->changeUpdateAt();

        $category->update();
    }
}
