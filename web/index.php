<?php
require(__DIR__ . '/../config/local.origin.php');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Cookie');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
