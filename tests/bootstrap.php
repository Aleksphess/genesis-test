<?php
error_reporting(E_ALL);
// Composer
require_once(dirname(__DIR__) . '/vendor/autoload.php');

// Environment
\Dotenv\Dotenv::createImmutable(dirname(__DIR__))->load();
