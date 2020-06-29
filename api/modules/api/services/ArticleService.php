<?php

declare(strict_types=1);

namespace api\modules\api\services;

use api\modules\api\cache\ArticleCacheInterface;
use api\modules\api\cache\CategoryCacheInterface;
use api\modules\api\exceptions\NotFoundArticleException;
use api\modules\api\exceptions\NotFoundCategoryException;
use api\modules\api\repository\ArticleRepositoryInterface;
use api\modules\api\repository\CategoryRepositoryInterface;
use api\modules\api\resources\Article;
use yii\data\DataProviderInterface;

class ArticleService implements ArticleServiceInterface
{
    private ArticleRepositoryInterface $repository;

    private CategoryRepositoryInterface $categoryRepository;

    private ArticleCacheInterface $cache;

    private CategoryCacheInterface $categoryCache;

    public function __construct(
        ArticleRepositoryInterface $repository,
        CategoryRepositoryInterface $categoryRepository,
        ArticleCacheInterface $cache,
        CategoryCacheInterface $categoryCache
    ) {
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->cache = $cache;
        $this->categoryCache = $categoryCache;
    }

    public function createArticle(array $params): Article
    {
        if (isset($params['category_id'])) {
            $category = $this->categoryRepository->findOneById((int)$params['category_id']);
            $article = $this->repository->createArticle($params);
            $article->setCategory($category);
            $this->repository->save($article);
            $this->cache->setArticle($article);
            $category->incrementArticle();
            $this->categoryRepository->save($category);
            $this->categoryCache->setCategory($category);

            return $article;
        }

        throw new NotFoundCategoryException(\sprintf('Not found id in request'));
    }

    public function updateArticle(string $alias, array $params): Article
    {
        $article = $this->repository->findOneByAlias($alias);
        if (isset($params['category_id'])) {
            $category = $this->categoryRepository->findOneById($params['category_id']);
            $article->setCategory($category);
        }
        $this->repository->update($article, $params);
        $this->cache->setArticle($article);

        return $article;
    }

    public function deleteArticle(string $alias): void
    {
        $article = $this->repository->delete($alias);
        $category = $this->categoryRepository->findOneByAlias($article->getAlias());
        $category->decrementArticle();
        $this->categoryRepository->save($category);
        $this->categoryCache->setCategory($category);
    }

    public function findArticle(string $alias): Article
    {
        try {
            return $this->cache->getArticle($alias);
        } catch (NotFoundArticleException $e) {
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
