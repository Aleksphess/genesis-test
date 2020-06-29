<?php
require(__DIR__ . '/../_bootstrap.php');

// Environment
//require(YII_APP_BASE_PATH . '/common/env.php');

//die('111');
// Bootstrap application
//require(YII_APP_BASE_PATH . '/common/config/bootstrap.php');
require(YII_APP_BASE_PATH . '/api/config/bootstrap.php');

$config = require(dirname(__DIR__, 2) . '/config/api/acceptance.php');

new yii\web\Application($config);