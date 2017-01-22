<?php
return [
    'rss' => 'post/rss',

    'users/<page:\d+>' => 'user/index',
    'users/<id>/<username>' => 'user/view',
    'users' => 'user/index',

    'news/<page:\d+>' => 'post/index',
    'news/<id>/<slug>' => 'post/view',
    'news/<slug>' => 'post/view',

    'auth' => 'site/auth',
    'terms' => 'site/terms',
    'doc/cookbook/ru/<page>' => 'cookbook/view',
    '1.1' => 'site/legacy',
    'doc/cookbook/ru/index' => 'cookbook/view',
    ['class' => 'app\components\RedirectUrlRule'],
    [
        'pattern' => 'qa/without-answer',
        'route' => 'qa/index',
        'defaults' => ['solved' => 0],
    ],
    [
        'pattern' => 'qa/solved',
        'route' => 'qa/index',
        'defaults' => ['solved' => 1],
    ],
    [
        'pattern' => 'qa/my',
        'route' => 'qa/index',
        'defaults' => ['individual' => 1],
    ],
];