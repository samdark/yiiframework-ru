<?php
namespace app\components;

use Yii;
use yii\web\UrlRuleInterface;

/**
 * Redirects 1.1 guide URLs to yiiframework.com
 */
class RedirectUrlRule implements UrlRuleInterface
{
    /**
     * @inheritdoc
     */
    public function parseRequest($manager, $request)
    {
        $url = $request->getUrl();
        if (preg_match('~^/(?:doc/guide|doc/blog)~', $url)) {
            Yii::$app->response->redirect('http://www.yiiframework.com' . $url, 301);
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function createUrl($manager, $route, $params)
    {
        return false;
    }
}