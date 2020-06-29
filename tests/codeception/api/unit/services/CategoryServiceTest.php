<?php

declare(strict_types=1);

namespace tests\codeception\api\unit\services;

use api\modules\api\cache\CategoryCacheInterface;
use api\modules\api\exceptions\NotFoundCategoryException;
use api\modules\api\repository\CategoryRepositoryInterface;
use api\modules\api\resources\Category;
use api\modules\api\services\CategoryService;
use api\modules\api\services\CategoryServiceInterface;
use Codeception\PHPUnit\TestCase;
use yii\data\DataProviderInterface;

class CategoryServiceTest extends TestCase
{
    private CategoryRepositoryInterface $repository;

    private CategoryCacheInterface $cache;

    private CategoryServiceInterface $service;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(CategoryRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cache = $this->getMockBuilder(CategoryCacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new CategoryService($this->repository, $this->cache);
    }

    public function testCreateCategory(): void
    {
        $testParams = [
            'title' => 'test',
            'description' => 'test',
            'alias' => 'test'
        ];

        $category = $this->createCategory();

        $this->repository->expects($this->once())
            ->method('createCategory')
            ->with($this->equalTo($testParams))
            ->willReturn($category);

        $this->repository->expects($this->once())
            ->method('save')
            ->with($this->equalTo($category));

        $this->cache->expects($this->once())
            ->method('setCategory')
            ->with($this->equalTo($category));

        $actualCategory = $this->service->createCategory($testParams);

        $this->assertEquals($category, $actualCategory);
    }

    public function testUpdateCategory(): void
    {
        $testParams = [
            'title' => 'test',
            'description' => 'test',
            'alias' => 'test'
        ];

        $category = $this->createCategory();

        $this->repository->expects($this->once())
            ->method('findOneByAlias')
            ->with($this->equalTo($testParams['alias']))
            ->willReturn($category);

        $this->repository->expects($this->once())
            ->method('update')
            ->with($this->equalTo($category));

        $this->cache->expects($this->once())
            ->method('setCategory')
            ->with($this->equalTo($category));

        $actualCategory = $this->service->updateCategory($testParams['alias'], $testParams);

        $this->assertEquals($category, $actualCategory);
    }

    public function testUpdateCategoryException(): void
    {
        $testParams = [
            'title' => 'test',
            'description' => 'test',
            'alias' => 'test'
        ];

        $this->repository->expects($this->once())
            ->method('findOneByAlias')
            ->with($this->equalTo($testParams['alias']))
            ->will($this->throwException(new NotFoundCategoryException()));

        $this->expectExceptionObject(new NotFoundCategoryException());

        $this->service->updateCategory($testParams['alias'], $testParams);
    }

    public function testDeleteCategory(): void
    {
        $testAlias = 'test';
        $this->repository->expects($this->once())
            ->method('delete')
            ->with($this->equalTo($testAlias));

        $this->service->deleteCategory($testAlias);
    }

    public function testDeleteCategoryException(): void
    {
        $testAlias = 'test';
        $this->repository->expects($this->once())
            ->method('delete')
            ->with($this->equalTo($testAlias))
            ->willThrowException(new NotFoundCategoryException());

        $this->expectException(NotFoundCategoryException::class);

        $this->service->deleteCategory($testAlias);
    }

    public function testFindByAliasFromCache(): void
    {
        $testAlias = 'test';
        $category = $this->createCategory();

        $this->cache->expects($this->once())
            ->method('getCategory')
            ->with($this->equalTo($testAlias))
            ->willReturn($category);

        $actualCategory = $this->service->findCategory($testAlias);

        $this->assertEquals($category, $actualCategory);
    }

    public function testFindByAliasFromMysql(): void
    {
        $testAlias = 'test';
        $category = $this->createCategory();

        $this->cache->expects($this->once())
            ->method('getCategory')
            ->with($this->equalTo($testAlias))
            ->willThrowException(new NotFoundCategoryException());

        $this->repository->expects($this->once())
            ->method('findOneByAlias')
            ->with($this->equalTo($testAlias))
            ->willReturn($category);

        $actualCategory = $this->service->findCategory($testAlias);

        $this->assertEquals($category, $actualCategory);
    }

    public function testFindByAliasException(): void
    {
        $testAlias = 'test';

        $this->cache->expects($this->once())
            ->method('getCategory')
            ->with($this->equalTo($testAlias))
            ->willThrowException(new NotFoundCategoryException());

        $this->repository->expects($this->once())
            ->method('findOneByAlias')
            ->with($this->equalTo($testAlias))
            ->willThrowException(new NotFoundCategoryException());

        $this->expectException(NotFoundCategoryException::class);

        $this->service->findCategory($testAlias);
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

    private function createCategory(): Category
    {
        return $this->getMockBuilder(Category::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
