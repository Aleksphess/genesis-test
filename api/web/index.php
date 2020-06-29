<?php

error_reporting(E_ALL);

// Composer
require(__DIR__ . '/../../vendor/autoload.php');

// Environment
require(__DIR__ . '/../config/env.php');

// Yii
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');

// Bootstrap application
require(__DIR__ . '/../config/bootstrap.php');

$config = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../config/base.php'),
    require(__DIR__ . '/../config/web.php')
);

(new yii\web\Application($config))->run();
