<?php

return [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'name' => 'Genesis Test News Microservice',
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'sourceLanguage' => 'en-US',
    'language' => 'en-US',
    'components' => [
        'urlManager' => require(__DIR__ . '/_urlManager.php'),
        'request' => [
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ]
        ],
        'user' => [
            'class' => \yii\web\User::class,
            'identityClass' => \yii\web\User::class,
            'enableSession' => false
        ],
        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => $_ENV['MYSQL_DSN'],
            'username' => $_ENV['MYSQL_USER'],
            'password' => $_ENV['MYSQL_PASS'],
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ],
        'cache' => [
            'class' => \yii\caching\MemCache::class,
            'useMemcached' => true,
            'servers' => [
                [
                    'host' => $_ENV['MEMCACHED_HOST'],
                    'port' => $_ENV['MEMCACHED_PORT'],
                    'weight' => 100,
                ],
            ],
        ]
    ],
];
