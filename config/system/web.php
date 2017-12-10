<?php
$params = array_merge($configurator->getConfig('params.php'), $configurator->getConfig('versions.php'));
$db = $configurator->getConfig('db.php');
$urls = $configurator->getConfig('urls.php');
$authclients = $configurator->getConfig('authclients.php');

return [
    'id' => 'yiiframework.ru',
    'name' => 'yiiframework.ru',
    'basePath' => dirname(dirname(__DIR__)),
    'bootstrap' => ['log'],
    'defaultRoute' => 'post/index',
    'language' => 'ru-RU',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => $authclients,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $urls,
            'normalizer' => [
                'class' => \yii\web\UrlNormalizer::class,
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
            ],
        ],
        'db' => $db,
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => YII_DEBUG,
        ],
        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true,
        ],
    ],
    'params' => $params,
];
