<?php
/**
 * This file used for enhanced IDE code autocompletion.
 * Note: To avoid "Multiple Implementations" PHPStorm warning and make autocomplete faster
 * exclude or "Mark as Plain Text" vendor/yiisoft/yii2/Yii.php file
 */

class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication
     */
    public static $app;

    /**
     * Все новые строки следует задавать на русском языке без использования функции Yii::t(),
     * а все имеющиеся вызовы Yii::t() постепенно удалять в пользу прямого использования русских строк.
     *
     * Ниже дана ссылка на соответствующий issue на GitHub.
     *
     * @deprecated
     * @see https://github.com/samdark/yiiframework-ru/issues/105
     *
     * @inheritdoc
     * @see BaseYii::t()
     */
    public static function t($category, $message, $params=[], $language=null) {}
}

abstract class BaseApplication extends yii\base\Application
{
}

/**
 * @property User $user
 */
class WebApplication extends yii\web\Application
{
}

class ConsoleApplication extends yii\console\Application
{
}

/**
 * @property \app\models\User $identity
 */
class User extends yii\web\User
{
}