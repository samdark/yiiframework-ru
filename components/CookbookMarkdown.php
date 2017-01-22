<?php

namespace app\components;

use yii\helpers\Markdown;

class CookbookMarkdown extends Markdown
{
    /**
     * @inheritdoc
     */
    public static function process($markdown, $flavor = null)
    {
        $content = parent::process($markdown, $flavor);

        $content = static::replaceCookbookClassesWithLinks($content);
        $content = static::replaceCookbookClassMethodsWithLinks($content);

        return $content;
    }

    /**
     * Замена названий классов Yii 1.1 на соответствующие им ссылки.
     *
     * Нас интересуют все вхождения в квадратных скобках, которые начинаются с букв:
     * "C" - классы компонентов (CComponent, CBehavior и т.д.)
     * "I" - интерфейсы (IFilter, IWebUser и т.д.)
     * "Y" - классы Yii и YiiBase
     *
     * Например: [CComponent], [IWebUser], [Yii] и т.д.
     *
     * @see http://www.yiiframework.com/doc/api
     *
     * @param string $content Обрабатываемый контент.
     * @return string Результирующий контент, в котором вставки классов заменены ссылками.
     */
    private static function replaceCookbookClassesWithLinks($content)
    {
        return preg_replace(
            '/\[((C|I|Y){1}\w+)\]/u',
            '<a href="http://www.yiiframework.com/doc/api/$1" rel="nofollow" target="_blank">$1</a>',
            $content
        );
    }

    /**
     * Замена названий методов классов Yii 1.1 на соответствующие им ссылки.
     * Работает по тому же принципу, что replaceCookbookClassesWithLinks за тем исключением,
     * что после названий методов мы ищем ещё и вхождение вида ::methodName.
     *
     * Например: [CComponent::raiseEvent], [CModel::afterValidate] и т.д.
     *
     * @see replaceCookbookClassesWithLinks
     *
     * @param string $content Обрабатываемый контент.
     * @return string Результирующий контент, в котором вставки методов классов заменены ссылками.
     */
    private static function replaceCookbookClassMethodsWithLinks($content)
    {
        return preg_replace(
            '/\[((C|I|Y){1}\w+)::(\w+)\]/u',
            '<a href="http://www.yiiframework.com/doc/api/$1#$3-detail" rel="nofollow" target="_blank">$1::$3()</a>',
            $content
        );
    }
}