<?php
return [
    'doc/cookbook/ru/<page>' => 'cookbook/view',
    ['class' => 'frontend\components\RedirectUrlRule'],
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