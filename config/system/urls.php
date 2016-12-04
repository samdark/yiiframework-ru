<?php
return [
    'auth' => 'site/auth',
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