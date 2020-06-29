<?php

return [
    'class' => \yii\web\UrlManager::class,
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        [
            'class' => \yii\rest\UrlRule::class,
            'tokens' => [
                '{id}' => '<id>'
            ],
            'controller' => 'api/article',
        ],
        [
            'class' => \yii\rest\UrlRule::class,
            'tokens' => [
                '{id}' => '<id>'
            ],
            'controller' => 'api/category',
        ],
    ]
];
