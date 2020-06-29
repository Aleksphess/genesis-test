<?php
require(__DIR__ . '/../_bootstrap.php');

// Environment
require(YII_APP_BASE_PATH . '/api/config/env.php');

// Bootstrap application

$config = require(dirname(__DIR__, 2) . '/config/functional.php');

new yii\web\Application($config);