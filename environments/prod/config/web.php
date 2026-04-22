<?php

$rollbarAccessToken = getenv('ROLLBAR_ACCESS_TOKEN');

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];

if (!empty($rollbarAccessToken)) {
    $config['bootstrap'][] = 'rollbar';
    $config['components']['rollbar'] = [
        'class' => 'baibaratsky\yii\rollbar\Rollbar',
        'accessToken' => $rollbarAccessToken,
    ];
    $config['components']['errorHandler'] = [
        'class' => 'baibaratsky\yii\rollbar\web\ErrorHandler',
    ];
}

return $config;
