<?php
return [
    'github' => [
        'class' => 'yii\authclient\clients\GitHub',
        'clientId' => 'github_client_id',
        'clientSecret' => 'github_client_secret',
    ],
    'facebook' => [
        'class' => 'yii\authclient\clients\Facebook',
        'clientId' => 'client_id',
        'clientSecret' => 'client_secret',
        'scope' => 'email',
    ],
    'twitter' => [
        'class' => 'yii\authclient\clients\Twitter',
        'consumerKey' => 'client_id',
        'consumerSecret' => 'client_secret',
        'scope' => 'email',
    ],
];