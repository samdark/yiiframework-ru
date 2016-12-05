<?php
$params = array_merge($configurator->getConfig('params.php'), $configurator->getConfig('versions.php'));
$db = $configurator->getConfig('db.php');
$urls = $configurator->getConfig('urls.php');
$authclients = $configurator->getConfig('authclients.php');

return [
    'id' => 'yiiframework.ru console',
    'name' => 'yiiframework.ru console',
    'basePath' => dirname(dirname(__DIR__)),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'db' => $db,
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
