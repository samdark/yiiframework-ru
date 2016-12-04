<?php
$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [

            ],
        ],
    ],
];

return $config;