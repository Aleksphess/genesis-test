<?php

declare(strict_types=1);

namespace api\modules\api\validation;

use indigerd\scenarios\Scenario;
use indigerd\scenarios\validation\factory\ValidatorCollectionFactory;
use indigerd\scenarios\validation\factory\ValidatorFactory;

class ArticleCreateScenario extends Scenario
{
    public function __construct(
        ValidatorFactory $validatorFactory,
        ValidatorCollectionFactory $validatorCollectionFactory,
        array $validationRules = []
    ) {
        $rules = [
            ['alias', 'required'],
            ['title', 'required'],
            ['description', 'required'],
            ['text', 'required'],
            ['category_id', 'required'],
        ];

        parent::__construct($validatorFactory, $validatorCollectionFactory, \array_merge($rules, $validationRules));
    }
}
