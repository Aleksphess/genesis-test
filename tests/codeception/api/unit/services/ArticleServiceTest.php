<?php

declare(strict_types=1);

namespace tests\codeception\api\unit\services;

use api\modules\api\cache\ArticleCacheInterface;
use api\modules\api\cache\CategoryCacheInterface;
use api\modules\api\exceptions\NotFoundArticleException;
use api\modules\api\exceptions\NotFoundCategoryException;
use api\modules\api\repository\ArticleRepositoryInterface;
use api\modules\api\repository\CategoryRepositoryInterface;
use api\modules\api\resources\Article;
use api\modules\api\resources\Category;
use api\modules\api\services\ArticleService;
use api\modules\api\services\ArticleServiceInterface;
use Codeception\PHPUnit\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use yii\data\DataProviderInterface;

class ArticleServiceTest extends TestCase
{
    private ArticleRepositoryInterface $repository;

    private ArticleCacheInterface $cache;

    private CategoryRepositoryInterface $categoryRepository;

    private CategoryCacheInterface $categoryCache;

    private ArticleServiceInterface $service;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(ArticleRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cache = $this->getMockBuilder(ArticleCacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->categoryRepository = $this->getMockBuilder(CategoryRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->categoryCache = $this->getMockBuilder(CategoryCacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new ArticleService(
            $this->repository,
            $this->categoryRepository,
            $this->cache,
            $this->categoryCache
        );
    }

    public function testCreateArticle(): void
    {
        $testParams = [
            'category_id' => 1,
            'title' => 'test',
            'description' => 'test',
            'text' => 'test'
        ];

        $article = $this->createArticle();
        $category = $this->createCategory();

        $this->categoryRepository->expects($this->once())
            ->method('findOneById')
            ->with($this->equalTo($testParams['category_id']))
            ->willReturn($category);

        $this->repository->expects($this->once())
            ->method('createArticle')
            ->with($this->equalTo($testParams))
            ->willReturn($article);

        $article->expects($this->once())
            ->method('setCategory')
            ->with($this->equalTo($category));

        $this->repository->expects($this->once())
            ->method('save')
            ->with($this->equalTo($article));

        $this->cache->expects($this->once())
            ->method('setArticle')
            ->with($this->equalTo($article));

        $category->expects($this->once())
            ->method('incrementArticle');

        $this->categoryRepository->expects($this->once())
            ->method('save')
            ->with($this->equalTo($category));

        $this->categoryCache->expects($this->once())
            ->method('setCategory')
            ->with($this->equalTo($category));

        $this->service->createArticle($testParams);
    }

    public function testNotFoundFieldCategoryException(): void
    {
        $testParams = [];

        $this->expectException(NotFoundCategoryException::class);

        $this->service->createArticle($testParams);
    }

    public function testNotFoundCategoryException(): void
    {
        $testParams = [
            'category_id' => 1,
            'title' => 'test',
        ];

        $this->categoryRepository->expects($this->once())
            ->method('findOneById')
            ->with($this->equalTo($testParams['category_id']))
            ->willThrowException(new NotFoundCategoryException());

        $this->expectException(NotFoundCategoryException::class);

        $this->service->createArticle($testParams);
    }

    public function testUpdateArticle(): void
    {
        $testParams = [
            'title' => 'test',
            'alias' => 'test'
        ];

        $article = $this->createArticle();
        $this->repository->expects($this->once())
            ->method('findOneByAlias')
            ->with($this->equalTo($testParams['alias']))
            ->willReturn($article);

        $this->repository->expects($this->once())
            ->method('update')
            ->with($this->equalTo($article), $this->equalTo($testParams));

        $this->cache->expects($this->once())
            ->method('setArticle')
            ->with($this->equalTo($article));

        $actualArticle = $this->service->updateArticle($testParams['alias'], $testParams);

        $this->assertEquals($article, $actualArticle);
    }

    public function testUpdateArticleNotFoundException(): void
    {
        $testParams = [
            'alias' => 'test',
        ];

        $this->repository->expects($this->once())
            ->method('findOneByAlias')
            ->with($this->equalTo($testParams['alias']))
            ->willThrowException(new NotFoundCategoryException());

        $this->expectException(NotFoundCategoryException::class);

        $this->service->updateArticle($testParams['alias'], $testParams);
    }

    public function updateArticleWithCategory(): void
    {
        $testParams = [
            'title' => 'test',
            'alias' => 'test',
            'category_id' => 1,
        ];

        $article = $this->createArticle();
        $category = $this->createCategory();

        $this->repository->expects($this->once())
            ->method('findOneByAlias')
            ->with($this->equalTo($testParams['alias']))
            ->willReturn($article);

        $this->categoryRepository->expects($this->once())
            ->method('findOneById')
            ->with($this->equalTo($testParams['category_id']))
            ->will($category);

        $article->expects($this->once())
            ->method('setCategory')
            ->with($this->equalTo($category));

        $this->repository->expects($this->once())
            ->method('update')
            ->with($this->equalTo($article), $this->equalTo($testParams));

        $this->cache->expects($this->once())
            ->method('setArticle')
            ->with($this->equalTo($article));

        $actualArticle = $this->service->updateArticle($testParams['alias'], $testParams);

        $this->assertEquals($article, $actualArticle);
    }

    public function updateArticleNotFoundCategory(): void
    {
        $testParams = [
            'title' => 'test',
            'alias' => 'test',
            'category_id' => 1,
        ];

        $article = $this->createArticle();

        $this->repository->expects($this->once())
            ->method('findOneByAlias')
            ->with($this->equalTo($testParams['alias']))
            ->willReturn($article);

        $this->categoryRepository->expects($this->once())
            ->method('findOneById')
            ->with($this->equalTo($testParams['category_id']))
            ->willThrowException(new NotFoundCategoryException());

        $this->expectException(NotFoundCategoryException::class);

        $this->service->updateArticle($testParams['alias'], $testParams);
    }

    public function testDelete(): void
    {
        $testAlias = 'test';

        $article = $this->createArticle();
        $category = $this->createCategory();

        $this->repository->expects($this->once())
            ->method('delete')
            ->with($this->equalTo($testAlias))
            ->willReturn($article);

        $this->categoryRepository->expects($this->once())
            ->method('findOneByAlias')
            ->with($this->equalTo($article->getAlias()))
            ->willReturn($category);

        $category->expects($this->once())
            ->method('decrementArticle');

        $this->categoryRepository->expects($this->once())
            ->method('save')
            ->with($this->equalTo($category));

        $this->categoryCache->expects($this->once())
            ->method('setCategory')
            ->with($this->equalTo($category));

        $this->service->deleteArticle($testAlias);
    }

    public function testDeleteArticleNotFound(): void
    {
        $testAlias = 'test';

        $this->repository->expects($this->once())
            ->method('delete')
            ->with($this->equalTo($testAlias))
            ->willThrowException(new NotFoundArticleException());

        $this->expectException(NotFoundArticleException::class);

        $this->service->deleteArticle($testAlias);
    }

    public function testDeleteArticleCategoryNotFound(): void
    {
        $testAlias = 'test';

        $article = $this->createArticle();

        $this->repository->expects($this->once())
            ->method('delete')
            ->with($this->equalTo($testAlias))
            ->willReturn($article);

        $this->categoryRepository->expects($this->once())
            ->method('findOneByAlias')
            ->with($this->equalTo($article->getAlias()))
            ->willThrowException(new NotFoundCategoryException());

        $this->expectException(NotFoundCategoryException::class);

        $this->service->deleteArticle($testAlias);
    }

    public function testFindArticle(): void
    {
        $testAlias = 'test';

        $article = $this->createArticle();

        $this->cache->expects($this->once())
            ->method('getArticle')
            ->with($this->equalTo($testAlias))
            ->willReturn($article);

        $actualArticle = $this->service->findArticle($testAlias);

        $this->assertEquals($article, $actualArticle);
    }

    public function testFindArticleFromMysql(): void
    {
        $testAlias = 'test';

        $article = $this->createArticle();

        $this->cache->expects($this->once())
            ->method('getArticle')
            ->with($this->equalTo($testAlias))
            ->willThrowException(new NotFoundArticleException());

        $this->repository->expects($this->once())
            ->method('findOneByAlias')
            ->with($this->equalTo($testAlias))
            ->willReturn($article);

        $actualArticle = $this->service->findArticle($testAlias);

        $this->assertEquals($article, $actualArticle);
    }

    public function testNotFounArticle(): void
    {
        $testAlias = 'test';

        $this->cache->expects($this->once())
            ->method('getArticle')
            ->with($this->equalTo($testAlias))
            ->willThrowException(new NotFoundArticleException());

        $this->repository->expects($this->once())
            ->method('findOneByAlias')
            ->with($this->equalTo($testAlias))
            ->willThrowException(new NotFoundArticleException());

        $this->expectException(NotFoundArticleException::class);

        $this->service->findArticle($testAlias);
    }

    public function testFindMany(): void
    {
        $testParams = [
            'sort' => [],
            'filter' => [],
        ];

        $dataProvider = $this->getMockBuilder(DataProviderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository->expects($this->once())
            ->method('findByParams')
            ->with($this->equalTo($testParams['filter']), $this->equalTo($testParams['sort']))
            ->willReturn($dataProvider);

        $actualDataProvider = $this->service->findAllByParams($testParams);

        $this->assertEquals($dataProvider, $actualDataProvider);
    }

    /**
     * @return Article|MockObject
     */
    private function createArticle(): Article
    {
        return $this->getMockBuilder(Article::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return Category|MockObject
     */
    private function createCategory(): Category
    {
        return $this->getMockBuilder(Category::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
