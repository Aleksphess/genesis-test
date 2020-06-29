<?php

declare(strict_types=1);

namespace api\modules\api\repository;

use api\modules\api\exceptions\NotFoundArticleException;
use api\modules\api\resources\Article;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class ArticleRepository extends ActiveQuery implements ArticleRepositoryInterface
{
    public function findOneByAlias(string $alias): Article
    {
        /**
         * @var Article $article
         */
        $article = $this->where(['alias' => $alias])->one();
        if (null === $article) {
            throw new NotFoundArticleException(\sprintf('Article not found by alias %s', $alias));
        }

        return $article;
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

    public function createArticle(array $params): Article
    {
        /**
         * @var Article $article
         */
        $article = new $this->modelClass;
        $article->load($params, '');
        $article->setCreateAt();
        $article->changeUpdateAt();
        $article->setNewStatus();

        return $article;
    }

    public function save(Article $article): void
    {
        $article->save();
    }

    public function delete(string $alias): Article
    {
        $article = $this->where(['alias' => $alias])->one();

        if (null === $article) {
            throw new NotFoundArticleException(\sprintf('Article not found by id %s', $alias));
        }

        $article->delete();

        return $article;
    }

    public function update(Article $article, array $params): void
    {
        $article->load($params, '');
        $article->changeUpdateAt();

        $article->update();
    }
}
