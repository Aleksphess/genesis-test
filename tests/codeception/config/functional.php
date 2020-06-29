<?php

return [
    'id' => 'Test',
    'basePath' => dirname(__DIR__, 3),
    'components' => [
        'urlManager' => require(dirname(__DIR__, 3) . '/api/config/_urlManager.php'),
        'request' => [
            'enableCsrfValidation' => false,
        ],
        'cache' => [
            'class' => \yii\caching\DummyCache::class
        ],
        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => $_ENV['MYSQL_DSN_TEST'],
            'username' => $_ENV['MYSQL_USER_TEST'],
            'password' => $_ENV['MYSQL_PASS_TEST'],
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ],
    ],
];
