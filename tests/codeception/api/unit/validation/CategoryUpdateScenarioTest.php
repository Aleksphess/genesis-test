<?php

declare(strict_types=1);

namespace tests\codeception\api\unit\validation;

use api\modules\api\validation\CategoryUpdateScenario;
use indigerd\scenarios\validation\factory\ValidatorCollectionFactory;
use indigerd\scenarios\validation\factory\ValidatorFactory;
use TypeError;

class CategoryUpdateScenarioTest extends AbstractScenario
{
    private CategoryUpdateScenario $scenario;

    public function setUp(): void
    {
        $this->scenario = new CategoryUpdateScenario(new ValidatorFactory(), new ValidatorCollectionFactory());
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
            'title' => 150,
        ];

        $this->expectException(TypeError::class);

        $this->scenario->validateRequest($this->createAndTestRequest($testParams));
    }
}
