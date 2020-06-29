<?php

declare(strict_types=1);

namespace tests\codeception\api;

class ArticleCest
{
    protected function getArticle(): array
    {
        return $this->getArticlesFixture()[0];
    }

    protected function getArticlesFixture(): array
    {
        return require(YII_APP_BASE_PATH . '/tests/codeception/common/fixtures/data/articles.php');
    }

    public function testCreateArticle(FunctionalTester $I): void
    {
        $article = $this->getArticle();
        $article['alias'] = 'test';

        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendPOST('/articles', $article);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function testFindArticle(FunctionalTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('/articles/' . $this->getArticle()['alias']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function testUpdateArticle(FunctionalTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendPUT('/articles/' . $this->getArticle()['alias'], ['title' => 'test']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function testDeleteArticle(FunctionalTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendDELETE('/articles/' . $this->getArticle()['alias']);
        $I->seeResponseCodeIs(204);
    }
}
