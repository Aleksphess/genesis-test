<?php

return [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'components' => [
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
        ],
    ],
];
