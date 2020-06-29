<?php
/**
 * Application configuration for console unit tests
 */
return yii\helpers\ArrayHelper::merge(
    require(dirname(__DIR__) . '/base.php'),
    require(dirname(__DIR__) . '/unit.php')
);