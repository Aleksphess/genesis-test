<?php

declare(strict_types=1);

namespace api\modules\api\services;

use api\modules\api\cache\CategoryCacheInterface;
use api\modules\api\exceptions\NotFoundCategoryException;
use api\modules\api\resources\Category;
use api\modules\api\repository\CategoryRepositoryInterface;
use yii\data\DataProviderInterface;

class CategoryService implements CategoryServiceInterface
{
    private CategoryRepositoryInterface $repository;

    private CategoryCacheInterface $cache;

    public function __construct(CategoryRepositoryInterface $repository, CategoryCacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    public function createCategory(array $params): Category
    {
        $category = $this->repository->createCategory($params);
        $this->repository->save($category);
        $this->cache->setCategory($category);

        return $category;
    }

    public function updateCategory(string $alias, array $params): Category
    {
        $category = $this->repository->findOneByAlias($alias);
        $this->repository->update($category, $params);
        $this->cache->setCategory($category);

        return $category;
    }

    public function deleteCategory(string $alias): void
    {
        $this->repository->delete($alias);
    }

    public function findCategory(string $alias): Category
    {
        try {
            return $this->cache->getCategory($alias);
        } catch (NotFoundCategoryException $e) {
            return $this->repository->findOneByAlias($alias);
        }
    }

    public function findAllByParams(array $params): DataProviderInterface
    {
        $sortParams = [];
        $filterParams = [];

        if (isset($params['sort'])) {
            $sortParams = $params['sort'];
        }

        if (isset($params['filter'])) {
            $filterParams = $params['filter'];
        }

        return $this->repository->findByParams($filterParams, $sortParams);
    }
}