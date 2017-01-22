<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class HighlightJSAsset extends AssetBundle
{
    public $css = [
        '//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/styles/default.min.css',
    ];

    public $js = [
        '//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js',
    ];

    public static function register($view)
    {
        $view->registerJs('hljs.initHighlightingOnLoad();', View::POS_END);

        return parent::register($view);
    }
}
