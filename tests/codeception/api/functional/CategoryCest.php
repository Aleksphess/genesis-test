<?php

declare(strict_types=1);

namespace tests\codeception\api;

class CategoryCest
{
    protected function getCategory(): array
    {
        return $this->getCategoriesFixture()[0];
    }

    protected function getCategoriesFixture(): array
    {
        return require(YII_APP_BASE_PATH . '/tests/codeception/common/fixtures/data/categories.php');
    }

    public function testCreateArticle(FunctionalTester $I): void
    {
        $article = $this->getCategory();
        $article['alias'] = 'test';

        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendPOST('/categories', $article);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function testFindArticle(FunctionalTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('/categories/' . $this->getCategory()['alias']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function testUpdateArticle(FunctionalTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendPUT('/categories/' . $this->getCategory()['alias'], ['title' => 'test']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function testDeleteArticle(FunctionalTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendDELETE('/categories/' . $this->getCategory()['alias']);
        $I->seeResponseCodeIs(204);
    }
}
