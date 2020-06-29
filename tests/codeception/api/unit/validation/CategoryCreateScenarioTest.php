<?php

declare(strict_types=1);

namespace tests\codeception\api\unit\validation;

use api\modules\api\validation\CategoryCreateScenario;
use indigerd\scenarios\exception\RequestValidateException;
use indigerd\scenarios\validation\factory\ValidatorCollectionFactory;
use indigerd\scenarios\validation\factory\ValidatorFactory;

class CategoryCreateScenarioTest extends AbstractScenario
{
    private CategoryCreateScenario $scenario;

    public function setUp(): void
    {
        $this->scenario = new CategoryCreateScenario(new ValidatorFactory(), new ValidatorCollectionFactory());
    }

    public function testSuccessValidate(): void
    {
        $testParams = [
            'alias' => 'test',
            'title' => 'test',
            'description' => 'test',
            'text' => 'test',
        ];

        $this->assertTrue($this->scenario->validateRequest($this->createAndTestRequest($testParams)));
    }

    public function testFailValidate(): void
    {
        $testParams = [
            'alias' => 'test',
            'title' => 'test',
            'description' => 'test',
        ];

        $this->expectException(RequestValidateException::class);

        $this->scenario->validateRequest($this->createAndTestRequest($testParams));
    }
}
