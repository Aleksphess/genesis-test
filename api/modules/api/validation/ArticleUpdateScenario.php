<?php

declare(strict_types=1);

namespace api\modules\api\validation;

use indigerd\scenarios\Scenario;
use indigerd\scenarios\validation\factory\ValidatorCollectionFactory;
use indigerd\scenarios\validation\factory\ValidatorFactory;

class ArticleUpdateScenario extends Scenario
{
    public function __construct(
        ValidatorFactory $validatorFactory,
        ValidatorCollectionFactory $validatorCollectionFactory,
        array $validationRules = []
    ) {
        $rules = [
            ['title', 'string'],
            ['description', 'string'],
            ['text', 'string'],
            ['category_id', 'integer'],
            ['status', 'in'],
        ];

        parent::__construct($validatorFactory, $validatorCollectionFactory, \array_merge($rules, $validationRules));
    }
}
