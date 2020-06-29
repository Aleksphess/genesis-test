<?php
/**
 * Application configuration shared by all applications and test types
 */
return [
    'controllerMap' => [
        'fixture' => [
            'class' => yii\faker\FixtureController::class,
            'fixtureDataPath' => '@tests/common/fixtures/data',
            'templatePath' => '@tests/common/templates/fixtures',
            'namespace' => 'tests\common\fixtures',
        ],
    ],
    'components' => [
        'urlManager' => [
            'showScriptName' => true,
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
