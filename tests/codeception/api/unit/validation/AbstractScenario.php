<?php

declare(strict_types=1);

namespace tests\codeception\api\unit\validation;

use Codeception\PHPUnit\TestCase;
use yii\web\Request;

abstract class AbstractScenario extends TestCase
{
    protected function createAndTestRequest(array $params): Request
    {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->setMethods(['getBodyParams'])
            ->getMock();

        $request
            ->expects($this->once())
            ->method('getBodyParams')
            ->willReturn($params);

        return $request;
    }
}
