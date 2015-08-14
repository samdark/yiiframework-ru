<?php

$root = dirname(dirname(__DIR__));

Yii::setAlias('common', $root . '/common');
Yii::setAlias('frontend', $root . '/frontend');
Yii::setAlias('backend', $root . '/backend');
Yii::setAlias('console', $root . '/console');

if (is_file($root . '/.env.php')) {
    require_once $root . '/.env.php';
}
