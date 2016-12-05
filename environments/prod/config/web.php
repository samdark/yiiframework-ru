<?php
$config = [
    'bootstrap' => [
        'rollbar',
    ],
    'components' => [
        'rollbar' => [
            'class' => 'baibaratsky\yii\rollbar\Rollbar',
            'accessToken' => '',
        ],
        'errorHandler' => [
            'class' => 'baibaratsky\yii\rollbar\web\ErrorHandler',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];

return $config;