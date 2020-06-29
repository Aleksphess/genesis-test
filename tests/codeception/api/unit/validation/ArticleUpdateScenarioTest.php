<?php

declare(strict_types=1);

namespace tests\codeception\api\unit\validation;

use api\modules\api\validation\ArticleUpdateScenario;
use indigerd\scenarios\exception\RequestValidateException;
use indigerd\scenarios\validation\factory\ValidatorCollectionFactory;
use indigerd\scenarios\validation\factory\ValidatorFactory;

class ArticleUpdateScenarioTest extends AbstractScenario
{
    private ArticleUpdateScenario $scenario;

    public function setUp(): void
    {
        $this->scenario = new ArticleUpdateScenario(new ValidatorFactory(), new ValidatorCollectionFactory());
    }

    public function testSuccessValidate(): void
    {
        $testParams = [
            'alias' => 'test',
        ];

        $this->assertTrue($this->scenario->validateRequest($this->createAndTestRequest($testParams)));
    }

    public function testFailValidate(): void
    {
        $testParams = [
            'category_id' => 'test',
        ];

        $this->expectException(RequestValidateException::class);

        $this->scenario->validateRequest($this->createAndTestRequest($testParams));
    }
}
