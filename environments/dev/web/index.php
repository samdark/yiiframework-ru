<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

require(__DIR__ . '/../util/Configurator.php');

$configurator = new \app\util\Configurator(__DIR__ . '/../config');
$config = $configurator->getConfig('web.php');

(new yii\web\Application($config))->run();
