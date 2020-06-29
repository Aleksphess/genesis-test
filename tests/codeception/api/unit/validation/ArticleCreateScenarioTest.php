<?php

declare(strict_types=1);

namespace tests\codeception\api\unit\validation;

use api\modules\api\validation\ArticleCreateScenario;
use indigerd\scenarios\exception\RequestValidateException;
use indigerd\scenarios\validation\factory\ValidatorCollectionFactory;
use indigerd\scenarios\validation\factory\ValidatorFactory;

class ArticleCreateScenarioTest extends AbstractScenario
{
    private ArticleCreateScenario $scenario;

    public function setUp(): void
    {
        $this->scenario = new ArticleCreateScenario(new ValidatorFactory(), new ValidatorCollectionFactory());
    }

    public function testSuccessValidate(): void
    {
        $testParams = [
            'alias' => 'test',
            'title' => 'test',
            'description' => 'test',
            'text' => 'test',
            'category_id' => 1,
        ];

        $this->assertTrue($this->scenario->validateRequest($this->createAndTestRequest($testParams)));
    }

    public function testFailValidate(): void
    {
        $testParams = [
            'alias' => 'test',
            'title' => 'test',
            'description' => 'test',
            'text' => 'test',
        ];

        $this->expectException(RequestValidateException::class);

        $this->scenario->validateRequest($this->createAndTestRequest($testParams));
    }
}
